<?php

namespace App\Services\Course;

use App\Exceptions\DomainException;
use App\Repositories\CourseRepository;
use App\Repositories\TeacherRepository;

class GetCoursesByTeacherService
{
    private $courseRepository;
    private $teacherRepository;

    public function __construct(CourseRepository $courseRepository, TeacherRepository $teacherRepository)
    {
        $this->courseRepository = $courseRepository;
        $this->teacherRepository = $teacherRepository;
    }

    public function execute(int $teacher_id, int $perPage = 5, int $page = 1)
    {
        $existingTeacher = $this->teacherRepository->getById($teacher_id);

        if (!$existingTeacher) {
            throw new DomainException(['Teacher not found'], 404);
        }

        return $this->courseRepository->getByTeacher($teacher_id, $perPage, $page);
    }
}
