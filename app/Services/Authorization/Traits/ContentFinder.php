<?php

namespace App\Services\Authorization\Traits;

use App\Exceptions\DomainException;
use App\Models\Content;

trait ContentFinder
{
    public function findContentOrFail(int $contentId): Content
    {
        $content = Content::find($contentId);

        if (!$content) {
            throw new DomainException(['Content not found'], 404);
        }

        return $content;
    }
}
