<?php

namespace App\Http\Resources\EnrollmentProgress;

use Illuminate\Http\Resources\Json\JsonResource;

class EnrollmentProgressResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "enrollment_id" => $this->enrollment_id,
            "lesson_id" => $this->lesson_id,
            "completed_at" => $this->completed_at,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
