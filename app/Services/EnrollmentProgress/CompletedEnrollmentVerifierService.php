<?php

namespace App\Services\EnrollmentProgress;

use App\Exceptions\DomainException;
use App\Repositories\EnrollmentProgressRepository;
use App\Repositories\EnrollmentRepository;
use App\Repositories\LessonRepository;

class CompletedEnrollmentVerifierService
{
    private $enrollmentProgressRepository;
    private $enrollmentRepository;
    private $lessonRepository;

    public function __construct(EnrollmentProgressRepository $enrollmentProgressRepository, EnrollmentRepository $enrollmentRepository, LessonRepository $lessonRepository)
    {
        $this->enrollmentProgressRepository = $enrollmentProgressRepository;
        $this->enrollmentRepository = $enrollmentRepository;
        $this->lessonRepository = $lessonRepository;
    }

    public function execute(int $enrollment_id)
    {
        $enrollment = $this->enrollmentRepository->getById($enrollment_id);
        if ($enrollment == null) {
            throw new DomainException(["Enrollment not found"], 404);
        }

        $lessons = $this->lessonRepository->getByCourse($enrollment->course_id);
        $lessons_viewed = $this->enrollmentProgressRepository->getByEnrollment($enrollment->id);

        return count($lessons) === count($lessons_viewed);
    }
}
