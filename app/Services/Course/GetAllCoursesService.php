<?php

namespace App\Services\Course;

use App\Repositories\CourseRepository;

class GetAllCoursesService
{
    private $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function execute()
    {
        return $this->courseRepository->getAll();
    }
}
