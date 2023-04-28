<?php

namespace App\Services\Authorization;

use App\Exceptions\DomainException;
use App\Models\Content;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Teacher;
use App\Services\Authorization\Traits\CourseFinder;
use App\Services\Authorization\Traits\LessonFinder;
use Illuminate\Support\Facades\Gate;

class ContentAuthorizationService
{
    use CourseFinder;
    use LessonFinder;

    public function store(Teacher $teacher, $course_id, $lesson_id): bool
    {
        $course = $this->findCourseOrFail($course_id);
        $lesson = $this->findLessonOrFail($lesson_id);
        if (Gate::denies('teacher-store-lesson-contents', [$course, $lesson])) {
            throw new DomainException(["Teacher does not own the course"], 403);
        }

        return true;
    }
}