<?php

namespace App\Services\Student;

use App\Exceptions\DomainException;
use App\Repositories\StudentRepository;
use Illuminate\Support\Facades\Hash;

class UpdateStudentService
{
    private $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    public function execute(array $data, int $id)
    {
        $existingStudent = $this->studentRepository->getById($id);
        if (!$existingStudent) {
            throw new DomainException(['Student not found'], 404);
        }

        $existingStudentByEmail = $this->studentRepository->findByEmail($data['email']);
        if ($existingStudentByEmail && $existingStudentByEmail->id != $id) {
            throw new DomainException(['E-mail is already in use.'], 409);
        }

        $data['password'] = Hash::make($data['password']);

        return $this->studentRepository->update($id, $data);
    }
}
