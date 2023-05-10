<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\EnrollmentProgress\EnrollmentProgressCollection;
use App\Http\Resources\EnrollmentProgress\EnrollmentProgressResource;
use App\Services\Authorization\EnrollmentProgressAuthorizationService;
use App\Services\EnrollmentProgress\CreateEnrollmentProgressService;
use App\Services\EnrollmentProgress\GetProgressByEnrollmentService;
use Illuminate\Http\Request;

class EnrollmentProgressController extends BaseController
{
    protected $createEnrollmentProgressService;
    protected $getProgressByEnrollmentService;

    protected $enrollmentProgressAuthorizationService;

    public function __construct(
        CreateEnrollmentProgressService $createEnrollmentProgressService,
        GetProgressByEnrollmentService $getProgressByEnrollmentService,
        EnrollmentProgressAuthorizationService $enrollmentProgressAuthorizationService
    ) {
        $this->createEnrollmentProgressService = $createEnrollmentProgressService;
        $this->getProgressByEnrollmentService = $getProgressByEnrollmentService;
        $this->enrollmentProgressAuthorizationService = $enrollmentProgressAuthorizationService;
    }

    public function store(Request $request, $enrollment_id)
    {
        $lesson_id = $request->lesson_id;

        $this->enrollmentProgressAuthorizationService->store($request->user(), $enrollment_id, $lesson_id);

        return $this->sendResponse(new EnrollmentProgressResource($this->createEnrollmentProgressService->execute($enrollment_id, $lesson_id)), "", 201);
    }

    public function getByEnrollment(Request $request, $enrollment_id)
    {
        $this->enrollmentProgressAuthorizationService->viewAll($request->user(), $enrollment_id);

        return $this->sendResponse(new EnrollmentProgressCollection($this->getProgressByEnrollmentService->execute($enrollment_id)), "", 200);
    }
}
