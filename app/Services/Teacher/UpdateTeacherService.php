<?php

namespace App\Services\Teacher;

use App\Exceptions\DomainException;
use App\Repositories\TeacherRepository;
use Illuminate\Support\Facades\Hash;

class UpdateTeacherService
{
    private $teacherRepository;

    public function __construct(TeacherRepository $teacherRepository)
    {
        $this->teacherRepository = $teacherRepository;
    }

    public function execute(array $data, int $id)
    {
        $existingTeacher = $this->teacherRepository->getById($id);
        if (!$existingTeacher) {
            throw new DomainException(['Teacher not found'], 404);
        }

        $existingTeacherByEmail = $this->teacherRepository->findByEmail($data['email']);
        if ($existingTeacherByEmail && $existingTeacherByEmail->id != $id) {
            throw new DomainException(['E-mail is already in use.'], 409);
        }

        $data['password'] = Hash::make($data['password']);

        return $this->teacherRepository->update($id, $data);
    }
}