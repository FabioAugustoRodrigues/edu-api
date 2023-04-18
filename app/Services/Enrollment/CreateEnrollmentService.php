<?php

namespace App\Services\Enrollment;

use App\Exceptions\DomainException;
use App\Repositories\CourseRepository;
use App\Repositories\EnrollmentRepository;
use App\Repositories\StudentRepository;

class CreateEnrollmentService
{
    private $enrollmentRepository;
    private $studentRepository;
    private $courseRepository;

    public function __construct(EnrollmentRepository $enrollmentRepository, StudentRepository $studentRepository, CourseRepository $courseRepository)
    {
        $this->enrollmentRepository = $enrollmentRepository;
        $this->studentRepository = $studentRepository;
        $this->courseRepository = $courseRepository;
    }

    public function execute(int $student_id, int $course_id)
    {
        $data = array();

        $existingStudent = $this->studentRepository->getById($student_id);
        if (!$existingStudent) {
            throw new DomainException(['Student not found'], 404);
        }

        $existingCourse = $this->courseRepository->getById($course_id);
        if (!$existingCourse) {
            throw new DomainException(['Course not found'], 404);
        }

        if ($existingCourse->status == "inactive") {
            throw new DomainException(['Course is inactive'], 400);
        }

        $data['student_id'] = $student_id;
        $data['course_id'] = $course_id;
        $data['status'] = 'in_progress';

        $enrollmentRepository = $this->enrollmentRepository->create($data);

        return $enrollmentRepository;
    }
}
