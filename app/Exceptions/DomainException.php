<?php

namespace App\Exceptions;

class DomainException extends ApplicationException
{
    private $errors;
    private $status;

    public function __construct(array $errors, int $status=500)
    {
        $this->errors = $errors;
        $this->status = $status;
    }

    public function status(): int
    {
        return $this->status;
    }

    public function help(): string
    {
        return "";
    }

    public function error(): string
    {
        return implode("\n", $this->errors);
    }
}