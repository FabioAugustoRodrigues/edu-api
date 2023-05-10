<?php

namespace App\Policies;

use App\Interfaces\UserInterface;
use App\Models\Enrollment;
use App\Models\Lesson;

class EnrollmentProgressPolicy
{
    public function store(UserInterface $user, Enrollment $enrollment, Lesson $lesson)
    {
        return $user->isStudent() && $user->id === $enrollment->student_id && $lesson->course_id === $enrollment->course_id;
    }

    public function viewAll(UserInterface $user, Enrollment $enrollment)
    {
        return $user->isStudent() && $user->id === $enrollment->student_id;
    }
}
