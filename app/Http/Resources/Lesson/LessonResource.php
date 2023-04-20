<?php

namespace App\Http\Resources\Lesson;

use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "course_id" => $this->course_id,
            "name" => $this->name,
            "lesson_order" => $this->lesson_order,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
