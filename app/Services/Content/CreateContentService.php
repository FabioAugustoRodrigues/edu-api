<?php

namespace App\Services\Content;

use App\Exceptions\DomainException;
use App\Repositories\ContentRepository;
use App\Repositories\LessonRepository;

class CreateContentService
{
    private $contentRepository;
    private $lessonRepository;

    public function __construct(ContentRepository $contentRepository, LessonRepository $lessonRepository)
    {
        $this->contentRepository = $contentRepository;
        $this->lessonRepository = $lessonRepository;
    }

    public function execute(array $data, int $lesson_id)
    {
        $existingLesson = $this->lessonRepository->getById($lesson_id);
        if (!$existingLesson) {
            throw new DomainException(['Lesson not found'], 404);
        }

        $data['lesson_id'] = $lesson_id;

        return $this->contentRepository->create($data);
    }
}
