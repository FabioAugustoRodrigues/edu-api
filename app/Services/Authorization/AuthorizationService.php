<?php

namespace App\Services\Authorization;

use App\Exceptions\DomainException;
use Illuminate\Support\Facades\Gate;

class AuthorizationService
{
    public function authorize(string $ability, $arguments = []): bool
    {
        if (Gate::denies($ability, $arguments)) {
            throw new DomainException(["Permission denied"], 403);
        }

        return true;
    }
}
