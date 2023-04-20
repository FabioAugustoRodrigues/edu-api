<?php

namespace App\Http\Resources\Enrollment;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EnrollmentCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection;
    }
}