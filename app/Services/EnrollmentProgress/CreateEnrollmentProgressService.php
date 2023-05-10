<?php

namespace App\Services\EnrollmentProgress;

use App\Repositories\EnrollmentProgressRepository;

class CreateEnrollmentProgressService
{
    private $enrollmentProgressRepository;

    public function __construct(EnrollmentProgressRepository $enrollmentProgressRepository)
    {
        $this->enrollmentProgressRepository = $enrollmentProgressRepository;
    }

    public function execute(int $enrollment_id, int $lesson_id)
    {
        $data = array();

        $data['enrollment_id'] = $enrollment_id;
        $data['lesson_id'] = $lesson_id;
        $data['completed_at'] = date("Y-m-d h:i:s");

        return $this->enrollmentProgressRepository->create($data);
    }
}
