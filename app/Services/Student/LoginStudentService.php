<?php

namespace App\Services\Student;

use App\Exceptions\DomainException;
use App\Repositories\StudentRepository;

class LoginStudentService
{
    private $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    public function execute(string $email, string $password)
    {
        $student = $this->studentRepository->findByEmail($email);
        if ($student == NULL) {
            throw new DomainException(["Incorrect login or password."], 401);
        }

        if (!password_verify($password, $student->password)) {
            throw new DomainException(["Incorrect login or password."], 401);
        }

        return $student->createToken('mobile', ['role:student'])->plainTextToken;
    }
}