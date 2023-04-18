<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Services\Enrollment\CreateEnrollmentService;
use Illuminate\Http\Request;

class EnrollmentController extends BaseController
{
    protected $createEnrollmentService;

    public function __construct(
        CreateEnrollmentService $createEnrollmentService
    ) {
        $this->createEnrollmentService = $createEnrollmentService;
    }

    public function store(Request $request)
    {
        $student_id = $request->user()->id;
        $course_id = $request->course_id;

        return $this->sendResponse($this->createEnrollmentService->execute($student_id, $course_id), "", 201);
    }
}
