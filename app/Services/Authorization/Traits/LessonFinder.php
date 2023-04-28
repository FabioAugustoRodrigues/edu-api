<?php

namespace App\Services\Authorization\Traits;

use App\Exceptions\DomainException;
use App\Models\Lesson;

trait LessonFinder
{
    public function findLessonOrFail(int $lessonId): Lesson
    {
        $lesson = Lesson::find($lessonId);

        if (!$lesson) {
            throw new DomainException(['Lesson not found'], 404);
        }

        return $lesson;
    }
}
