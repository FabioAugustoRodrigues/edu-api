<?php

namespace App\Http\Resources\Course;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CourseCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection;
    }
}