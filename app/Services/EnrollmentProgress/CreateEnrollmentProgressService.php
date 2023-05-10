<?php

namespace App\Services\EnrollmentProgress;

use App\Exceptions\DomainException;
use App\Repositories\EnrollmentProgressRepository;
use App\Repositories\EnrollmentRepository;

class CreateEnrollmentProgressService
{
    private $enrollmentProgressRepository;
    private $enrollmentRepository;

    private $completedEnrollmentVerifierService;

    public function __construct(EnrollmentProgressRepository $enrollmentProgressRepository, EnrollmentRepository $enrollmentRepository, CompletedEnrollmentVerifierService $completedEnrollmentVerifierService)
    {
        $this->enrollmentProgressRepository = $enrollmentProgressRepository;
        $this->enrollmentRepository = $enrollmentRepository;
        $this->completedEnrollmentVerifierService = $completedEnrollmentVerifierService;
    }

    public function execute(int $enrollment_id, int $lesson_id)
    {
        if ($this->enrollmentProgressRepository->getByEnrollmentAndLesson($enrollment_id, $lesson_id) != null) {
            throw new DomainException(
                ["A record of this progress already exists"],
                409
            );
        }

        $data = array();

        $data['enrollment_id'] = $enrollment_id;
        $data['lesson_id'] = $lesson_id;
        $data['completed_at'] = date("Y-m-d h:i:s");

        $enrollmentProgress = $this->enrollmentProgressRepository->create($data);

        if ($this->completedEnrollmentVerifierService->execute($enrollment_id)) {
            $this->enrollmentRepository->update($enrollment_id, ["status" => "completed"]);
        }

        return $enrollmentProgress;
    }
}
