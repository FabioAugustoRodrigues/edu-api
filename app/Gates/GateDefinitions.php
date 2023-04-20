<?php

namespace App\Gates;

use App\Exceptions\DomainException;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Teacher;
use Illuminate\Support\Facades\Gate;

class GateDefinitions
{
    public static function defineCourseGates()
    {
        Gate::define('teacher-update-post', function (Teacher $teacher, $course_id) {
            $course = Course::find($course_id);
            if ($course == NULL) {
                throw new DomainException(["Course not found"], 404);
            }

            return $teacher->id === $course->teacher_id;
        });
    }

    public static function defineEnrollmentGates()
    {
        Gate::define('teacher-view-course-enrollments', function (Teacher $teacher, $course_id) {
            $course = Course::find($course_id);
            if ($course == NULL) {
                throw new DomainException(["Course not found"], 404);
            }

            return $teacher->id === $course->teacher_id;
        });
    }

    public static function defineLessonGates()
    {
        Gate::define('teacher-store-course-lessons', function (Teacher $teacher, $course_id) {
            $course = Course::find($course_id);
            if ($course == NULL) {
                throw new DomainException(["Course not found"], 404);
            }

            return $teacher->id === $course->teacher_id;
        });

        Gate::define('teacher-update-lesson-name', function (Teacher $teacher, $course_id) {
            $course = Course::find($course_id);
            if ($course == NULL) {
                throw new DomainException(["Course not found"], 404);
            }

            return $teacher->id === $course->teacher_id;
        });

        Gate::define('teacher-update-lesson-orders', function (Teacher $teacher, $course_id, $lesson_ids) {
            $course = Course::find($course_id);
            if ($course == NULL) {
                throw new DomainException(["Course not found"], 404);
            }

            if ($teacher->id != $course->teacher_id) {
                return false;
            }

            foreach ($lesson_ids as $lesson) {
                $lessonFound = Lesson::find($lesson["lesson_id"]);
                if ($lessonFound == NULL || $lessonFound->course_id != $course_id) {
                    return false;
                }
            }

            return true;
        });
    }
}
