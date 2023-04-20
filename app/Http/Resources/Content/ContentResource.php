<?php

namespace App\Http\Resources\Content;

use Illuminate\Http\Resources\Json\JsonResource;

class ContentResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "lesson_id" => $this->lesson_id,
            "name" => $this->name,
            "description" => $this->description,
            "url" => $this->url,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
