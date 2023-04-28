<?php

namespace App\Policies;

use App\Interfaces\UserInterface;
use App\Models\Content;
use App\Models\Course;
use App\Models\Lesson;

class ContentPolicy
{
    public function store(UserInterface $user, Course $course, Lesson $lesson)
    {
        $lessonBelongsToCourse = $lesson->course_id === $course->id;

        if ($user->isTeacher() && $lessonBelongsToCourse) {
            return true;
        }
    }

    public function update(UserInterface $user, Course $course, Lesson $lesson, Content $content)
    {
        $contentBelongsToLesson = $content->lesson_id === $content->id;
        $lessonBelongsToCourse = $lesson->course_id === $course->id;

        if ($user->isTeacher() && $user->id === $course->teacher_id && $contentBelongsToLesson && $lessonBelongsToCourse) {
            return true;
        }

        return false;
    }

    public function viewAll(UserInterface $user, Course $course, Lesson $lesson)
    {
        $lessonBelongsToCourse = $lesson->course_id === $course->id;

        if ($user->isTeacher() && $user->id === $course->teacher_id && $lessonBelongsToCourse) {
            return true;
        }

        if ($user->isStudent() && $course->enrolledIn($user) && $lessonBelongsToCourse) {
            return true;
        }

        return false;
    }
}
