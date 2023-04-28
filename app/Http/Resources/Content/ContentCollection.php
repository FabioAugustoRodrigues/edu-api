<?php

namespace App\Http\Resources\Content;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ContentCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection;
    }
}