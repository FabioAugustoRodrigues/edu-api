<?php

namespace App\Services\Authorization;

use App\Exceptions\DomainException;
use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Support\Facades\Gate;

class EnrollmentAuthorizationService
{
    private function findCourseOrFail($course_id): Course
    {
        $course = Course::find($course_id);
        if (!$course) {
            throw new DomainException(["Course not found"], 404);
        }

        return $course;
    }

    public function view(Teacher $teacher, $course_id): bool
    {
        $course = $this->findCourseOrFail($course_id);
        if (Gate::denies('teacher-view-course-enrollments', $course)) {
            throw new DomainException(["Teacher does not own the course"], 403);
        }

        return true;
    }
}
