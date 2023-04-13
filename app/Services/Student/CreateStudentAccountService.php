<?php

namespace App\Services\Student;

use App\Exceptions\DomainException;
use App\Repositories\StudentRepository;
use App\Utils\SnGeneratorUtil;
use Illuminate\Support\Facades\Hash;

class CreateStudentAccountService
{
    private $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    public function execute(array $data)
    {
        $existingStudent = $this->studentRepository->findByEmail($data['email']);
        
        if ($existingStudent) {
            throw new DomainException(['E-mail is alrady in use.'], 409);
        }

        $data['password'] = Hash::make($data['password']);
        $data['sn'] = SnGeneratorUtil::generate();

        $student = $this->studentRepository->create($data);

        return $student;
    }
}