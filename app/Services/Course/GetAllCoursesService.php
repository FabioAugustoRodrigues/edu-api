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

    public function execute(int $perPage = 5, int $page = 1, array $searchParams = [])
    {
        return $this->courseRepository->getAll($perPage, $page, $searchParams);
    }
}
