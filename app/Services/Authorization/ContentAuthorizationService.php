<?php

namespace App\Services\Authorization;

use App\Exceptions\DomainException;
use App\Interfaces\UserInterface;
use App\Services\Authorization\Traits\ContentFinder;
use App\Services\Authorization\Traits\CourseFinder;
use App\Services\Authorization\Traits\LessonFinder;
use Illuminate\Support\Facades\Gate;

class ContentAuthorizationService
{
    use CourseFinder;
    use LessonFinder;
    use ContentFinder;

    public function store(UserInterface $user, $course_id, $lesson_id): bool
    {
        $course = $this->findCourseOrFail($course_id);
        $lesson = $this->findLessonOrFail($lesson_id);
        if (Gate::denies('user-store-lesson-contents', [$course, $lesson])) {
            throw new DomainException(["User does not own the course"], 403);
        }

        return true;
    }

    public function update(UserInterface $user, $course_id, $lesson_id, $content_id): bool
    {
        $course = $this->findCourseOrFail($course_id);
        $lesson = $this->findLessonOrFail($lesson_id);
        $content = $this->findContentOrFail($content_id);
        if (Gate::denies('user-update-lesson-contents', [$course, $lesson, $content])) {
            throw new DomainException(["User does not own the course"], 403);
        }

        return true;
    }

    public function viewAll(UserInterface $user, $course_id, $lesson_id): bool
    {
        $course = $this->findCourseOrFail($course_id);
        $lesson = $this->findLessonOrFail($lesson_id);
        if (Gate::denies('user-view-all-lesson-contents', [$course, $lesson])) {
            throw new DomainException(["User does not own the course"], 403);
        }

        return true;
    }
}
