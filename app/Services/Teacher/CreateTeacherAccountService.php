<?php

namespace App\Services\Teacher;

use App\Exceptions\DomainException;
use App\Repositories\TeacherRepository;
use Illuminate\Support\Facades\Hash;

class CreateTeacherAccountService
{
    private $teacherRepository;

    public function __construct(TeacherRepository $teacherRepository)
    {
        $this->teacherRepository = $teacherRepository;
    }

    public function execute(array $data)
    {
        $existingTeacher = $this->teacherRepository->findByEmail($data['email']);
        
        if ($existingTeacher) {
            throw new DomainException(['E-mail is alrady in use.'], 409);
        }

        $data['password'] = Hash::make($data['password']);

        $teacher = $this->teacherRepository->create($data);

        return $teacher;
    }
}