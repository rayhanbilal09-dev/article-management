<?php

namespace App\Services;

use App\Models\AllowedWord;

class CommentModerationService
{
    /**
     * Determine if the comment content passes the moderation whitelist.
     * If the whitelist is empty, it always passes.
     * If not empty, it must contain at least one of the allowed words/phrases (case-insensitive).
     */
    public function passes(string $body): bool
    {
        $allowedWords = AllowedWord::pluck('word');

        if ($allowedWords->isEmpty()) {
            return true;
        }

        $bodyLower = strtolower($body);

        foreach ($allowedWords as $word) {
            if (str_contains($bodyLower, strtolower($word))) {
                return true;
            }
        }

        return false;
    }
}
