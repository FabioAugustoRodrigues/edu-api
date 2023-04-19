<?php

namespace App\Services\Lesson;

use App\Exceptions\DomainException;
use App\Repositories\CourseRepository;
use App\Repositories\LessonRepository;

class CreateLessonService
{
    private $lessonRepository;
    private $courseRepository;

    public function __construct(LessonRepository $lessonRepository, CourseRepository $courseRepository)
    {
        $this->lessonRepository = $lessonRepository;
        $this->courseRepository = $courseRepository;
    }

    public function execute(array $data, int $course_id)
    {
        $existingCourse = $this->courseRepository->getById($course_id);
        if (!$existingCourse) {
            throw new DomainException(['Course not found'], 404);
        }

        if ($this->lessonRepository->getByCourseAndOrder($course_id, $data['lesson_order'])) {
            throw new DomainException(['A lesson with the same order already exists in this course. Please choose a different order'], 409);
        }

        $data['course_id'] = $course_id;

        return $this->lessonRepository->create($data);
    }
}
