<?php

namespace App\Gates;

use App\Exceptions\DomainException;
use App\Models\Course;
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
    }
}
