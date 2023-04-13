<?php

namespace App\Exceptions;

use JsonSerializable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;

class Error implements Arrayable, Jsonable, JsonSerializable
{
    private $help;
    private $error;

    public function __construct(string $help, string $error)
    {
        $this->help = $help;
        $this->error = $error;
    }

    public function toArray(): array
    {
        return [
            'success' => false,
            'data' => null,
            'message' => $this->error,
            'help' => $this->help,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toJson($options = 0.0)
    {
        $jsonEncoded = json_encode($this->jsonSerialize(), $options);
        throw_unless($jsonEncoded, JsonEncodeException::class);
        return $jsonEncoded;
    }
}