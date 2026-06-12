<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use App\Models\Media;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ArticleMediaTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    /**
     * Test creating an article with cover and gallery media.
     */
    public function test_can_create_article_with_cover_and_media(): void
    {
        $user = User::factory()->create();
        
        $cover = UploadedFile::fake()->image('cover.jpg');
        $media1 = UploadedFile::fake()->image('gallery1.png');
        $media2 = UploadedFile::fake()->image('gallery2.png');

        $response = $this->actingAs($user)->post(route('articles.store'), [
            'title' => 'My First Article',
            'content' => 'Content goes here.',
            'status' => 'draft',
            'cover_image' => $cover,
            'media' => [$media1, $media2],
        ]);

        $response->assertRedirect(route('articles.index'));
        
        $article = Article::first();
        $this->assertNotNull($article->cover_image);
        Storage::disk('public')->assertExists($article->cover_image);

        $this->assertCount(2, $article->media);
        foreach ($article->media as $mediaItem) {
            Storage::disk('public')->assertExists($mediaItem->file_path);
        }
    }

    /**
     * Test uploading media to an existing article.
     */
    public function test_can_upload_media_to_existing_article(): void
    {
        $user = User::factory()->create();
        $article = Article::create([
            'user_id' => $user->id,
            'title' => 'Existing Article',
            'slug' => 'existing-article',
            'content' => 'Content',
            'status' => 'draft',
        ]);

        $file = UploadedFile::fake()->image('new_item.jpg');

        $response = $this->actingAs($user)->post(route('articles.media.upload', $article->id), [
            'media' => [$file],
        ]);

        $response->assertRedirect();
        $this->assertCount(1, $article->fresh()->media);
        Storage::disk('public')->assertExists($article->fresh()->media->first()->file_path);
    }

    /**
     * Test reordering article media.
     */
    public function test_can_reorder_media(): void
    {
        $user = User::factory()->create();
        $article = Article::create([
            'user_id' => $user->id,
            'title' => 'Article',
            'slug' => 'article',
            'content' => 'Content',
            'status' => 'draft',
        ]);

        $media1 = Media::create([
            'article_id' => $article->id,
            'type' => 'image',
            'file_path' => 'path1.jpg',
            'order' => 0,
        ]);

        $media2 = Media::create([
            'article_id' => $article->id,
            'type' => 'image',
            'file_path' => 'path2.jpg',
            'order' => 1,
        ]);

        $response = $this->actingAs($user)->post(route('articles.media.reorder', $article->id), [
            'order' => [$media2->id, $media1->id],
        ]);

        $response->assertStatus(302);
        $this->assertEquals(0, $media2->fresh()->order);
        $this->assertEquals(1, $media1->fresh()->order);
    }

    /**
     * Test setting a gallery image as cover.
     */
    public function test_can_set_gallery_image_as_cover(): void
    {
        $user = User::factory()->create();
        $article = Article::create([
            'user_id' => $user->id,
            'title' => 'Article',
            'slug' => 'article',
            'content' => 'Content',
            'status' => 'draft',
        ]);

        $media = Media::create([
            'article_id' => $article->id,
            'type' => 'image',
            'file_path' => 'path.jpg',
            'order' => 0,
        ]);

        $response = $this->actingAs($user)->post(route('articles.set-cover', $article->id), [
            'media_id' => $media->id,
        ]);

        $response->assertRedirect();
        $this->assertEquals($media->file_path, $article->fresh()->cover_image);
    }

    /**
     * Test that deleting a media item removes the file and clears cover if it matched.
     */
    public function test_deleting_media_removes_file_and_updates_cover(): void
    {
        $user = User::factory()->create();
        
        $file = UploadedFile::fake()->image('photo.jpg');
        $path = $file->store('articles', 'public');

        $article = Article::create([
            'user_id' => $user->id,
            'title' => 'Article',
            'slug' => 'article',
            'content' => 'Content',
            'status' => 'draft',
            'cover_image' => $path,
        ]);

        $media = Media::create([
            'article_id' => $article->id,
            'type' => 'image',
            'file_path' => $path,
            'order' => 0,
        ]);

        Storage::disk('public')->assertExists($path);

        $response = $this->actingAs($user)->delete(route('media.destroy', $media->id));
        
        $response->assertRedirect();
        $this->assertDatabaseMissing('media', ['id' => $media->id]);
        $this->assertNull($article->fresh()->cover_image);
        Storage::disk('public')->assertMissing($path);
    }

    /**
     * Test scheduled publishing visibility rules.
     */
    public function test_scheduled_publishing_visibility(): void
    {
        $user = User::factory()->create();

        // 1. Article published now/past - should be visible
        $visibleArticle = Article::create([
            'user_id' => $user->id,
            'title' => 'Visible Article',
            'slug' => 'visible-article',
            'content' => 'Content',
            'status' => 'published',
            'published_at' => now()->subDay(),
        ]);

        // 2. Article scheduled in future - should be hidden
        $scheduledArticle = Article::create([
            'user_id' => $user->id,
            'title' => 'Scheduled Article',
            'slug' => 'scheduled-article',
            'content' => 'Content',
            'status' => 'published',
            'published_at' => now()->addDay(),
        ]);

        // 3. Draft Article - should be hidden
        $draftArticle = Article::create([
            'user_id' => $user->id,
            'title' => 'Draft Article',
            'slug' => 'draft-article',
            'content' => 'Content',
            'status' => 'draft',
            'published_at' => now()->subDay(),
        ]);

        // Public index page check
        $response = $this->get(route('public.articles.index'));
        $response->assertSee($visibleArticle->title);
        $response->assertDontSee($scheduledArticle->title);
        $response->assertDontSee($draftArticle->title);

        // Individual article show page checks
        $this->get(route('public.articles.show', $visibleArticle->slug))->assertStatus(200);
        $this->get(route('public.articles.show', $scheduledArticle->slug))->assertStatus(404);
        $this->get(route('public.articles.show', $draftArticle->slug))->assertStatus(404);
    }
}
