<?php

namespace App\Services\Enrollment;

use App\Exceptions\DomainException;
use App\Repositories\CourseRepository;
use App\Repositories\EnrollmentRepository;

class GetEnrollmentsByCourseService
{
    private $enrollmentRepository;
    private $courseRepository;

    public function __construct(EnrollmentRepository $enrollmentRepository, CourseRepository $courseRepository)
    {
        $this->enrollmentRepository = $enrollmentRepository;
        $this->courseRepository = $courseRepository;
    }

    public function execute(int $course_id, int $perPage = 5, int $page = 1)
    {
        $existingCourse = $this->courseRepository->getById($course_id);
        if (!$existingCourse) {
            throw new DomainException(['Course not found'], 404);
        }

        return $this->enrollmentRepository->getByCourse($course_id);
    }
}
