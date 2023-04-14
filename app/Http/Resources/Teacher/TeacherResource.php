<?php

namespace App\Http\Resources\Teacher;

use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "bio" => $this->bio,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
