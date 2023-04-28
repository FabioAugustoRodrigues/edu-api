<?php

namespace App\Services\Authorization;

use App\Exceptions\DomainException;
use App\Interfaces\UserInterface;
use App\Services\Authorization\Traits\CourseFinder;
use Illuminate\Support\Facades\Gate;

class CourseAuthorizationService
{
    use CourseFinder;

    public function update(UserInterface $user, $course_id): bool
    {
        $course = $this->findCourseOrFail($course_id);
        if (Gate::denies('user-update-course', $course)) {
            throw new DomainException(["User does not own the course"], 403);
        }

        return true;
    }
}
