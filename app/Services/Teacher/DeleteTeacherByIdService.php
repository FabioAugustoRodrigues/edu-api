<?php

namespace App\Services\Teacher;

use App\Exceptions\DomainException;
use App\Repositories\TeacherRepository;

class DeleteTeacherByIdService
{
    private $teacherRepository;

    public function __construct(TeacherRepository $teacherRepository)
    {
        $this->teacherRepository = $teacherRepository;
    }

    public function execute(int $id)
    {
        $existingTeacher = $this->teacherRepository->getById($id);
        
        if (!$existingTeacher) {
            throw new DomainException(['Teacher not found'], 404);
        }

        $existingTeacher->tokens()->delete();
        return $this->teacherRepository->delete($id);
    }
}