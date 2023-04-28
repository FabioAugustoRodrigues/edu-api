<?php

namespace App\Services\Content;

use App\Exceptions\DomainException;
use App\Repositories\ContentRepository;

class UpdateContentService
{
    private $contentRepository;

    public function __construct(ContentRepository $contentRepository)
    {
        $this->contentRepository = $contentRepository;
    }

    public function execute(array $data, int $id)
    {
        $existingContent = $this->contentRepository->getById($id);
        if (!$existingContent) {
            throw new DomainException(['Content not found'], 404);
        }

        return $this->contentRepository->update($id, $data);
    }
}
