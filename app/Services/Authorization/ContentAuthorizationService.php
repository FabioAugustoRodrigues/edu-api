<?php

namespace App\Services\Authorization;

use App\Exceptions\DomainException;
use App\Models\Content;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Teacher;
use Illuminate\Support\Facades\Gate;

class ContentAuthorizationService
{
    private function findCourseOrFail($course_id): Course
    {
        $course = Course::find($course_id);
        if (!$course) {
            throw new DomainException(["Course not found"], 404);
        }

        return $course;
    }

    private function findLessonOrFail($lesson_id): Lesson
    {
        $lesson = Lesson::find($lesson_id);
        if (!$lesson) {
            throw new DomainException(["Lesson not found"], 404);
        }

        return $lesson;
    }

    private function findContentOrFail($content_id): Content
    {
        $content = Content::find($content_id);
        if (!$content) {
            throw new DomainException(["Content not found"], 404);
        }

        return $content;
    }

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
