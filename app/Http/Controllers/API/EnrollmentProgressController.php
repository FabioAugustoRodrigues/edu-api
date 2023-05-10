<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\EnrollmentProgress\EnrollmentProgressResource;
use App\Services\Authorization\EnrollmentProgressAuthorizationService;
use App\Services\EnrollmentProgress\CreateEnrollmentProgressService;
use Illuminate\Http\Request;

class EnrollmentProgressController extends BaseController
{
    protected $createEnrollmentProgressService;

    protected $enrollmentProgressAuthorizationService;

    public function __construct(
        CreateEnrollmentProgressService $createEnrollmentProgressService,
        EnrollmentProgressAuthorizationService $enrollmentProgressAuthorizationService
    ) {
        $this->createEnrollmentProgressService = $createEnrollmentProgressService;
        $this->enrollmentProgressAuthorizationService = $enrollmentProgressAuthorizationService;
    }

    public function store(Request $request, $enrollment_id)
    {
        $lesson_id = $request->lesson_id;

        $this->enrollmentProgressAuthorizationService->store($request->user(), $enrollment_id, $lesson_id);

        return $this->sendResponse(new EnrollmentProgressResource($this->createEnrollmentProgressService->execute($enrollment_id, $lesson_id)), "", 201);
    }
}
