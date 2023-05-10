<?php

namespace App\Http\Resources\EnrollmentProgress;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EnrollmentProgressCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection;
    }
}