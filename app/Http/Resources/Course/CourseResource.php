<?php

namespace App\Http\Resources\Course;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "teacher_id" => $this->teacher_id,
            "name" => $this->name,
            "description" => $this->description,
            "status" => $this->status,
            "start_date" => $this->start_date,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
