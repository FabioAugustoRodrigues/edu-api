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

    public function execute(int $enrollment_id, int $perPage = 5, int $page = 1)
    {
        return $this->enrollmentProgressRepository->getByEnrollment($enrollment_id, $perPage, $page);
    }
}
