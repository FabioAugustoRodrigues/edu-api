<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Services\EnrollmentProgress\CreateEnrollmentProgressService;
use Illuminate\Http\Request;

class EnrollmentProgressController extends BaseController
{
    protected $createEnrollmentProgressService;

    public function __construct(
        CreateEnrollmentProgressService $createEnrollmentProgressService
    ) {
        $this->createEnrollmentProgressService = $createEnrollmentProgressService;
    }

    public function store(Request $request, $enrollment_id)
    {
        $lesson_id = $request->lesson_id;

        return $this->sendResponse($this->createEnrollmentProgressService->execute($enrollment_id, $lesson_id), "", 201);
    }
}
