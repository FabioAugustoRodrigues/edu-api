<?php

namespace App\Services\Enrollment;

use App\Exceptions\DomainException;
use App\Repositories\EnrollmentRepository;
use App\Repositories\StudentRepository;

class GetEnrollmentsByStudentService
{
    private $enrollmentRepository;
    private $studentRepository;

    public function __construct(EnrollmentRepository $enrollmentRepository, StudentRepository $studentRepository)
    {
        $this->enrollmentRepository = $enrollmentRepository;
        $this->studentRepository = $studentRepository;
    }

    public function execute(int $student_id)
    {
        $existingStudent = $this->studentRepository->getById($student_id);
        if (!$existingStudent) {
            throw new DomainException(['Student not found'], 404);
        }

        return $this->enrollmentRepository->getByStudent($student_id);
    }
}
