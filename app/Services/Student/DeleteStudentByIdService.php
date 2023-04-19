<?php

namespace App\Services\Student;

use App\Exceptions\DomainException;
use App\Repositories\StudentRepository;

class DeleteStudentByIdService
{
    private $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    public function execute(int $id)
    {
        $existingStudent = $this->studentRepository->getById($id);
        
        if (!$existingStudent) {
            throw new DomainException(['Student not found'], 404);
        }

        $existingStudent->tokens()->delete();
        return $this->studentRepository->delete($id);
    }
}