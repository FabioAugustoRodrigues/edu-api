<?php

namespace App\Http\Resources\Student;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "sn" => $this->sn,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
