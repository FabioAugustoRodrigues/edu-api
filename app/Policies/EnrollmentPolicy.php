<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\Teacher;

class EnrollmentPolicy
{
    public function view(Teacher $teacher, Course $course)
    {
        return $teacher->id === $course->teacher_id;
    }
}
