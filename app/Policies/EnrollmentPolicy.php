<?php

namespace App\Policies;

use App\Interfaces\UserInterface;
use App\Models\Course;

class EnrollmentPolicy
{
    public function view(UserInterface $user, Course $course)
    {
        return $user->isTeacher() && $user->id === $course->teacher_id;
    }
}
