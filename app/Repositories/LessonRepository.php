<?php

namespace App\Repositories;

use App\Models\Lesson;

class LessonRepository
{
    protected $model;

    public function __construct(Lesson $model)
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

    public function getByCourseAndOrder($course_id, $lesson_order)
    {
        return $this->model->where('course_id', $course_id)->where('lesson_order', $lesson_order)->first();
    }

    public function getByCourse(int $course_id, int $perPage = 5, int $page = 1)
    {
        $query = $this->model->query();
        $query->where('course_id', $course_id);

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
