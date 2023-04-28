<?php

namespace App\Services\Authorization;

use App\Exceptions\DomainException;
use App\Interfaces\UserInterface;
use App\Services\Authorization\Traits\CourseFinder;
use App\Services\Authorization\Traits\LessonFinder;
use Illuminate\Support\Facades\Gate;

class LessonAuthorizationService
{
    use CourseFinder;
    use LessonFinder;

    public function store(UserInterface $user, $course_id): bool
    {
        $course = $this->findCourseOrFail($course_id);
        if (Gate::denies('user-store-course-lessons', $course)) {
            throw new DomainException(["User does not own the course"], 403);
        }

        return true;
    }

    public function updateName(UserInterface $user, $course_id, $lesson_id): bool
    {
        $course = $this->findCourseOrFail($course_id);
        $lesson = $this->findLessonOrFail($lesson_id);
        if (Gate::denies('user-update-lesson-name', [$course, $lesson])) {
            throw new DomainException(["User does not own the course"], 403);
        }

        return true;
    }

    public function updateOrders(UserInterface $user, int $course_id, array $lessonIds): bool
    {
        $course = $this->findCourseOrFail($course_id);
        if (Gate::denies('user-update-lesson-orders', [$course, $lessonIds])) {
            throw new DomainException(["User does not own the course"], 403);
        }

        return true;
    }
}
