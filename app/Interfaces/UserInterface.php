<?php

namespace App\Interfaces;

interface UserInterface
{
    public function isTeacher(): bool;

    public function isStudent(): bool;
}
