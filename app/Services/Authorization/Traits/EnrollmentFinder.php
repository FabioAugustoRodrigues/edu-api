<?php

namespace App\Services\Authorization\Traits;

use App\Exceptions\DomainException;
use App\Models\Enrollment;

trait EnrollmentFinder
{
    public function findEnrollmentOrFail(int $enrollmentId): Enrollment
    {
        $enrollment = Enrollment::find($enrollmentId);

        if (!$enrollment) {
            throw new DomainException(['Enrollment not found'], 404);
        }

        return $enrollment;
    }
}
