<?php

namespace App\Services\Content;

use App\Exceptions\DomainException;
use App\Repositories\ContentRepository;
use App\Repositories\LessonRepository;

class GetContentsByLessonService
{
    private $contentRepository;
    private $lessonRepository;

    public function __construct(ContentRepository $contentRepository, LessonRepository $lessonRepository)
    {
        $this->contentRepository = $contentRepository;
        $this->lessonRepository = $lessonRepository;
    }

    public function execute(int $lesson_id)
    {
        $existingLesson = $this->lessonRepository->getById($lesson_id);
        if (!$existingLesson) {
            throw new DomainException(['Lesson not found'], 404);
        }

        return $this->contentRepository->getByLesson($lesson_id);
    }
}
