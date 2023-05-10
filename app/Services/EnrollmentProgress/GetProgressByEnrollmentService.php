<?php

namespace App\Services\EnrollmentProgress;

use App\Repositories\EnrollmentProgressRepository;

class GetProgressByEnrollmentService
{
    private $enrollmentProgressRepository;

    public function __construct(EnrollmentProgressRepository $enrollmentProgressRepository)
    {
        $this->enrollmentProgressRepository = $enrollmentProgressRepository;
    }

    public function execute(int $enrollment_id)
    {
        return $this->enrollmentProgressRepository->getByEnrollment($enrollment_id);
    }
}
