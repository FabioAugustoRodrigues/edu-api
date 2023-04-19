<?php

namespace App\Services\Course;

use App\Exceptions\DomainException;
use App\Repositories\CourseRepository;

class GetCourseByIdService
{
    private $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function execute(int $id)
    {
        $existingCourse = $this->courseRepository->getById($id);
        if (!$existingCourse) {
            throw new DomainException(["Course not found"], 404);
        }

        return $existingCourse;
    }
}
