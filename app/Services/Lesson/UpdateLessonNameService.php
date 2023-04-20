<?php

namespace App\Services\Lesson;

use App\Exceptions\DomainException;
use App\Repositories\LessonRepository;

class UpdateLessonNameService
{
    private $lessonRepository;

    public function __construct(LessonRepository $lessonRepository)
    {
        $this->lessonRepository = $lessonRepository;
    }

    public function execute(int $lesson_id, string $name)
    {
        $existingLesson = $this->lessonRepository->getById($lesson_id);
        if (!$existingLesson) {
            throw new DomainException(['Lesson not found'], 404);
        }

        $existingLesson->name = $name;

        return $existingLesson->save();
    }
}
