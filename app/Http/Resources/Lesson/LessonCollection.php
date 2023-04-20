<?php

namespace App\Http\Resources\Lesson;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LessonCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection;
    }
}
