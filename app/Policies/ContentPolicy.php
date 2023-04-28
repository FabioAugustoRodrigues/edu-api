<?php

namespace App\Policies;

use App\Models\Content;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Teacher;

class ContentPolicy
{
    public function store(Teacher $teacher, Course $course, Lesson $lesson)
    {
        return ($lesson->course_id === $course->id && $teacher->id === $course->teacher_id);
    }
}
