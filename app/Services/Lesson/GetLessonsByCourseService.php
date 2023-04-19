<?php

namespace App\Services\Lesson;

use App\Exceptions\DomainException;
use App\Repositories\CourseRepository;
use App\Repositories\LessonRepository;

class GetLessonsByCourseService
{
    private $lessonRepository;
    private $courseRepository;

    public function __construct(LessonRepository $lessonRepository, CourseRepository $courseRepository)
    {
        $this->lessonRepository = $lessonRepository;
        $this->courseRepository = $courseRepository;
    }

    public function execute(int $course_id)
    {
        $existingCourse = $this->courseRepository->getById($course_id);
        if (!$existingCourse) {
            throw new DomainException(['Course not found'], 404);
        }

        return $this->lessonRepository->getByCourse($course_id);
    }
}
