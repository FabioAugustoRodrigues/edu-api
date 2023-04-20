<?php

namespace App\Http\Resources\Enrollment;

use Illuminate\Http\Resources\Json\JsonResource;

class EnrollmentResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "student_id" => $this->student_id,
            "course_id" => $this->course_id,
            "status" => $this->status,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
