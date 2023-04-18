<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Services\Enrollment\CreateEnrollmentService;
use App\Services\Enrollment\GetEnrollmentsByStudentService;
use Illuminate\Http\Request;

class EnrollmentController extends BaseController
{
    protected $createEnrollmentService;
    protected $getEnrollmentsByStudentService;

    public function __construct(
        CreateEnrollmentService $createEnrollmentService,
        GetEnrollmentsByStudentService $getEnrollmentsByStudentService
    ) {
        $this->createEnrollmentService = $createEnrollmentService;
        $this->getEnrollmentsByStudentService = $getEnrollmentsByStudentService;
    }

    public function store(Request $request)
    {
        $student_id = $request->user()->id;
        $course_id = $request->course_id;

        return $this->sendResponse($this->createEnrollmentService->execute($student_id, $course_id), "", 201);
    }

    public function getByStudent(Request $request, $student_id)
    {
        return $this->sendResponse($this->getEnrollmentsByStudentService->execute($student_id), "", "200");
    }
}
