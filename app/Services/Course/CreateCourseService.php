<?php

namespace App\Services\Course;

use App\Exceptions\DomainException;
use App\Repositories\CourseRepository;
use App\Repositories\TeacherRepository;

class CreateCourseService
{
    private $courseRepository;
    private $teacherRepository;

    public function __construct(CourseRepository $courseRepository, TeacherRepository $teacherRepository)
    {
        $this->courseRepository = $courseRepository;
        $this->teacherRepository = $teacherRepository;
    }

    public function execute(array $data, int $teacher_id)
    {
        $existingTeacher = $this->teacherRepository->getById($teacher_id);
        if (!$existingTeacher) {
            throw new DomainException(['Teacher not found'], 404);
        }

        $data['teacher_id'] = $teacher_id;

        if ($data['start_date'] < date('Y-m-d')) {
            throw new DomainException(['Invalid start date. Please provide a date equal to or after the current date.'], 400);
        }

        $course = $this->courseRepository->create($data);

        return $course;
    }
}