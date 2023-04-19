<?php

namespace App\Helpers\Authorization;

use App\Exceptions\DomainException;
use App\Models\Course;

class CourseAuthorization
{
    public function validateOwnership(int $teacher_id, int $course_id)
    {
        $course = Course::where('id', $course_id)
                        ->where('teacher_id', $teacher_id)
                        ->first();

        if (!$course) {
            throw new DomainException(['Teacher does not own the course'], 403);
        }
    }
}