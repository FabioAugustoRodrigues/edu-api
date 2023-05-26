<?php

namespace App\Repositories;

use App\Models\EnrollmentProgress;

class EnrollmentProgressRepository
{
    protected $model;

    public function __construct(EnrollmentProgress $model)
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

    public function getByEnrollmentAndLesson($enrollment_id, $lesson_id)
    {
        return $this->model->where("enrollment_id", $enrollment_id)->where("lesson_id", $lesson_id)->first();
    }

    public function getByEnrollment($enrollment_id, int $perPage = 5, int $page = 1)
    {
        $query = $this->model->query();
        $query->where('enrollment_id', $enrollment_id);

        return $query->paginate($perPage, ['*'], 'page', $page);
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
}
