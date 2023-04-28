<?php

namespace App\Policies;

use App\Interfaces\UserInterface;
use App\Models\Course;
use App\Models\Lesson;

class LessonPolicy
{
    public function store(UserInterface $user, Course $course)
    {
        return $user->isTeacher() && $user->id === $course->teacher_id;
    }

    public function updateName(UserInterface $user, Course $course, Lesson $lesson)
    {
        return ($user->isTeacher() && $user->id === $course->teacher_id && $lesson->course_id === $course->id);
    }

    public function updateOrder(UserInterface $user, Course $course, array $lessonIds)
    {
        if ($user->id !== $course->teacher_id || !$user->isTeacher()) {
            return false;
        }

        foreach ($lessonIds as $lesson) {
            $lessonFound = Lesson::find($lesson["lesson_id"]);
            if ($lessonFound == NULL || $lessonFound->course_id != $course->id) {
                return false;
            }
        }

        return true;
    }
}
