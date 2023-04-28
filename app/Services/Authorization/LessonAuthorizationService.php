<?php

namespace App\Services\Authorization;

use App\Exceptions\DomainException;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Teacher;
use Illuminate\Support\Facades\Gate;

class LessonAuthorizationService
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

    public function store(Teacher $teacher, $course_id): bool
    {
        $course = $this->findCourseOrFail($course_id);
        if (Gate::denies('teacher-store-course-lessons', $course)) {
            throw new DomainException(["Teacher does not own the course"], 403);
        }

        return true;
    }

    public function updateName(Teacher $teacher, $course_id, $lesson_id): bool
    {
        $course = $this->findCourseOrFail($course_id);
        $lesson = $this->findLessonOrFail($lesson_id);
        if (Gate::denies('teacher-update-lesson-name', [$course, $lesson])) {
            throw new DomainException(["Teacher does not own the course"], 403);
        }

        return true;
    }

    public function updateOrders(Teacher $teacher, int $course_id, array $lessonIds): bool
    {
        $course = $this->findCourseOrFail($course_id);
        if (Gate::denies('teacher-update-lesson-orders', [$course, $lessonIds])) {
            throw new DomainException(["Teacher does not own the course"], 403);
        }

        return true;
    }
}
