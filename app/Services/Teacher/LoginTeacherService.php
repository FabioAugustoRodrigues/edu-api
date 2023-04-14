<?php

namespace App\Services\Teacher;

use App\Exceptions\DomainException;
use App\Repositories\TeacherRepository;

class LoginTeacherService
{
    private $teacherRepository;

    public function __construct(TeacherRepository $teacherRepository)
    {
        $this->teacherRepository = $teacherRepository;
    }

    public function execute(string $email, string $password)
    {
        $teacher = $this->teacherRepository->findByEmail($email);
        if ($teacher == NULL) {
            throw new DomainException(["Incorrect login or password."], 401);
        }

        if (!password_verify($password, $teacher->password)) {
            throw new DomainException(["Incorrect login or password."], 401);
        }

        return $teacher->createToken('mobile', ['role:teacher'])->plainTextToken;
    }
}