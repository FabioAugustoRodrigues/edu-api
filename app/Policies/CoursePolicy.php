<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\Teacher;

class CoursePolicy
{
    public function update(Teacher $teacher, Course $course)
    {
        return $teacher->id === $course->teacher_id;
    }
}
