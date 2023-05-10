<?php

namespace App\Services\Authorization;

use App\Exceptions\DomainException;
use App\Interfaces\UserInterface;
use App\Services\Authorization\Traits\EnrollmentFinder;
use App\Services\Authorization\Traits\LessonFinder;
use Illuminate\Support\Facades\Gate;

class EnrollmentProgressAuthorizationService
{
    use EnrollmentFinder;
    use LessonFinder;

    public function store(UserInterface $user, $enrollment_id, $lesson_id): bool
    {
        $lesson = $this->findLessonOrFail($lesson_id);
        $enrollment = $this->findEnrollmentOrFail($enrollment_id);

        if (Gate::denies('user-store-enrollment-progress', [$enrollment, $lesson])) {
            throw new DomainException(["User does not own the course"], 403);
        }

        return true;
    }
}
