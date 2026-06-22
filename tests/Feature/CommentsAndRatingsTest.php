<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Comment;
use App\Models\CommentReport;
use App\Models\AllowedWord;
use App\Models\User;
use App\Models\Rating;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentsAndRatingsTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected User $admin;
    protected Article $article;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->admin = User::factory()->create(['role' => 'superadmin']);
        
        // Create a published article
        $this->article = Article::create([
            'user_id' => $this->user->id,
            'title' => 'Mengapa Belajar Laravel Sangat Menyenangkan',
            'slug' => 'mengapa-belajar-laravel-sangat-menyenangkan',
            'content' => 'Ini adalah konten artikel Laravel yang sangat bermanfaat.',
            'status' => 'published',
            'published_at' => now()->subDay(),
        ]);
    }

    /**
     * Test guest cannot comment.
     */
    public function test_guest_cannot_post_comment(): void
    {
        $response = $this->post(route('articles.comments.store', $this->article), [
            'body' => 'Komentar saya.',
        ]);

        $response->assertRedirect('/login');
    }

    /**
     * Test authenticated user can comment.
     */
    public function test_authenticated_user_can_post_comment(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('articles.comments.store', $this->article), [
                'body' => 'Komentar yang sangat bermanfaat dan mendalam.',
            ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('comments', [
            'article_id' => $this->article->id,
            'user_id' => $this->user->id,
            'body' => 'Komentar yang sangat bermanfaat dan mendalam.',
            'parent_id' => null,
        ]);
    }

    /**
     * Test nested replies (2-level comment structure).
     */
    public function test_authenticated_user_can_reply_to_comment(): void
    {
        $comment = Comment::create([
            'article_id' => $this->article->id,
            'user_id' => $this->user->id,
            'body' => 'Komentar Utama',
        ]);

        $response = $this->actingAs($this->user)
            ->post(route('articles.comments.store', $this->article), [
                'body' => 'Ini adalah balasan/reply untuk komentar utama.',
                'parent_id' => $comment->id,
            ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('comments', [
            'article_id' => $this->article->id,
            'user_id' => $this->user->id,
            'body' => 'Ini adalah balasan/reply untuk komentar utama.',
            'parent_id' => $comment->id,
        ]);
    }

    /**
     * Test whitelist words validation.
     */
    public function test_comment_whitelist_validation(): void
    {
        // 1. Create whitelist words
        AllowedWord::create(['word' => 'bagus']);
        AllowedWord::create(['word' => 'mantap']);

        // 2. Submit comment containing whitelist word -> should pass
        $response1 = $this->actingAs($this->user)
            ->post(route('articles.comments.store', $this->article), [
                'body' => 'Artikel ini sangat bagus sekali!',
            ]);
        $response1->assertSessionHasNoErrors();
        $this->assertDatabaseHas('comments', ['body' => 'Artikel ini sangat bagus sekali!']);

        // 3. Submit comment NOT containing any whitelist word -> should fail
        $response2 = $this->actingAs($this->user)
            ->post(route('articles.comments.store', $this->article), [
                'body' => 'Komentar yang tidak lolos filter.',
            ]);
        $response2->assertSessionHasErrors('body');
        $this->assertDatabaseMissing('comments', ['body' => 'Komentar yang tidak lolos filter.']);
    }

    /**
     * Test upsert rating and average.
     */
    public function test_authenticated_user_can_upsert_rating(): void
    {
        // 1. First rating -> 5 stars
        $response = $this->actingAs($this->user)
            ->post(route('articles.ratings.upsert', $this->article), [
                'rating' => 5,
            ]);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('ratings', [
            'article_id' => $this->article->id,
            'user_id' => $this->user->id,
            'rating' => 5,
        ]);
        $this->assertEquals(5.0, $this->article->fresh()->average_rating);

        // 2. Second user rating -> 4 stars
        $otherUser = User::factory()->create();
        $this->actingAs($otherUser)
            ->post(route('articles.ratings.upsert', $this->article), [
                'rating' => 4,
            ]);
        $this->assertEquals(4.5, $this->article->fresh()->average_rating);

        // 3. Upsert rating of the first user -> update from 5 to 3 stars
        $responseUpdate = $this->actingAs($this->user)
            ->post(route('articles.ratings.upsert', $this->article), [
                'rating' => 3,
            ]);
        
        $this->assertDatabaseHas('ratings', [
            'article_id' => $this->article->id,
            'user_id' => $this->user->id,
            'rating' => 3,
        ]);
        // Total ratings should still be 2 (one per user)
        $this->assertEquals(2, $this->article->ratings()->count());
        // Average should be (3 + 4) / 2 = 3.5
        $this->assertEquals(3.5, $this->article->fresh()->average_rating);
    }

    /**
     * Test reporting a comment.
     */
    public function test_authenticated_user_can_report_comment(): void
    {
        $comment = Comment::create([
            'article_id' => $this->article->id,
            'user_id' => $this->user->id,
            'body' => 'Komentar kasar',
        ]);

        $response = $this->actingAs($this->user)
            ->post(route('comments.report', $comment), [
                'reason' => 'Komentar kasar / Abusive / Kebencian',
            ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('comment_reports', [
            'comment_id' => $comment->id,
            'user_id' => $this->user->id,
            'reason' => 'Komentar kasar / Abusive / Kebencian',
            'status' => 'pending',
        ]);
    }

    /**
     * Test admin moderation dashboard actions.
     */
    public function test_admin_can_manage_reports_and_moderation(): void
    {
        $offendingUser = User::factory()->create();
        $comment = Comment::create([
            'article_id' => $this->article->id,
            'user_id' => $offendingUser->id,
            'body' => 'Komentar tidak layak',
        ]);

        $report = CommentReport::create([
            'comment_id' => $comment->id,
            'user_id' => $this->user->id,
            'reason' => 'Spam',
            'status' => 'pending',
        ]);

        // 1. Admin views reports page
        $responseIndex = $this->actingAs($this->admin)->get(route('reports.index'));
        $responseIndex->assertStatus(200);
        $responseIndex->assertSee('Komentar tidak layak');

        // 2. Admin blocks offending user
        $responseBlock = $this->actingAs($this->admin)
            ->post(route('reports.users.block', $offendingUser));
        $responseBlock->assertSessionHasNoErrors();
        $this->assertTrue($offendingUser->fresh()->is_blocked);

        // 3. Admin deletes the comment
        $responseDelete = $this->actingAs($this->admin)
            ->delete(route('reports.comments.destroy', $comment));
        $responseDelete->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
        // The report should be cascade-deleted
        $this->assertDatabaseMissing('comment_reports', ['id' => $report->id]);
    }

    /**
     * Test that blocked user cannot access authenticated pages.
     */
    public function test_blocked_user_cannot_access_protected_routes(): void
    {
        $blockedUser = User::factory()->create(['is_blocked' => true]);

        // Trying to access dashboard
        $response = $this->actingAs($blockedUser)->get(route('dashboard'));
        
        // Should be logged out and redirected to login with error message
        $response->assertRedirect(route('login'));
        $this->assertGuest();
        
        // Try logging in via post
        $responseLogin = $this->post('/login', [
            'email' => $blockedUser->email,
            'password' => 'password', // default factory password is 'password' or hashed
        ]);
        
        $this->assertGuest();
    }
}
