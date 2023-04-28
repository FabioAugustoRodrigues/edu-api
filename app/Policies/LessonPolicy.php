<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Teacher;

class LessonPolicy
{
    public function store(Teacher $teacher, Course $course)
    {
        return $teacher->id === $course->teacher_id;
    }

    public function updateName(Teacher $teacher, Course $course, Lesson $lesson)
    {
        return ($teacher->id === $course->teacher_id && $lesson->course_id === $course->id);
    }

    public function updateOrder(Teacher $teacher, Course $course, array $lessonIds)
    {
        if ($teacher->id !== $course->teacher_id) {
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
