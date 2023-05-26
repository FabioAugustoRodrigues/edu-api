<?php

namespace App\Repositories;

use App\Models\Enrollment;

class EnrollmentRepository
{
    protected $model;

    public function __construct(Enrollment $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getById($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $record = $this->getById($id);
        $record->update($data);

        return $record->refresh();
    }

    public function delete($id)
    {
        $record = $this->getById($id);

        return $record->delete();
    }

    public function getByStudentAndCourse(int $student_id, int $course_id)
    {
        return $this->model->where('student_id', $student_id)->where('course_id', $course_id)->first();
    }

    public function getByStudent(int $student_id, int $perPage = 5, int $page = 1)
    {
        $query = $this->model->query();
        $query->where('student_id', $student_id);

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    public function getByCourse(int $course_id, int $perPage = 5, int $page = 1)
    {
        $query = $this->model->query();
        $query->where('course_id', $course_id);

        return $query->paginate($perPage, ['*'], 'page', $page);
    }
}
