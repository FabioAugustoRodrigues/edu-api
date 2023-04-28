<?php

namespace App\Policies;

use App\Interfaces\UserInterface;
use App\Models\Course;

class CoursePolicy
{
    public function update(UserInterface $user, Course $course)
    {
        return $user->isTeacher() && $user->id === $course->teacher_id;
    }
}
