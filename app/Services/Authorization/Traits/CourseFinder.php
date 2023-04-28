<?php

namespace App\Services\Authorization\Traits;

use App\Exceptions\DomainException;
use App\Models\Course;

trait CourseFinder
{
    public function findCourseOrFail(int $courseId): Course
    {
        $course = Course::find($courseId);

        if (!$course) {
            throw new DomainException(['Course not found'], 404);
        }

        return $course;
    }
}
