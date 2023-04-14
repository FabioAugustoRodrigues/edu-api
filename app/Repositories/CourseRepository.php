<?php

namespace App\Repositories;

use App\Models\Course;

class CourseRepository
{
    protected $model;

    public function __construct(Course $model)
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
}