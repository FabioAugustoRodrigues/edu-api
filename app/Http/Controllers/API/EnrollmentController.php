<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\Enrollment\EnrollmentCollection;
use App\Http\Resources\Enrollment\EnrollmentResource;
use App\Services\Authorization\EnrollmentAuthorizationService;
use App\Services\Enrollment\CreateEnrollmentService;
use App\Services\Enrollment\GetEnrollmentsByCourseService;
use App\Services\Enrollment\GetEnrollmentsByStudentService;
use Illuminate\Http\Request;

class EnrollmentController extends BaseController
{
    protected $createEnrollmentService;
    protected $getEnrollmentsByStudentService;
    protected $getEnrollmentsByCourseService;

    protected $enrollmentAuthorizationService;

    public function __construct(
        CreateEnrollmentService $createEnrollmentService,
        GetEnrollmentsByStudentService $getEnrollmentsByStudentService,
        GetEnrollmentsByCourseService $getEnrollmentsByCourseService,
        EnrollmentAuthorizationService $enrollmentAuthorizationService
    ) {
        $this->createEnrollmentService = $createEnrollmentService;
        $this->getEnrollmentsByStudentService = $getEnrollmentsByStudentService;
        $this->getEnrollmentsByCourseService = $getEnrollmentsByCourseService;
        $this->enrollmentAuthorizationService = $enrollmentAuthorizationService;
    }

    public function store(Request $request)
    {
        $student_id = $request->user()->id;
        $course_id = $request->course_id;

        return $this->sendResponse(new EnrollmentResource($this->createEnrollmentService->execute($student_id, $course_id)), "", 201);
    }

    public function getByStudent(Request $request, $student_id)
    {
        return $this->sendResponse(new EnrollmentCollection($this->getEnrollmentsByStudentService->execute($student_id)), "", 200);
    }

    public function getByCourse(Request $request, $course_id)
    {
        $this->enrollmentAuthorizationService->view($request->user(), $course_id);

        return $this->sendResponse(new EnrollmentCollection($this->getEnrollmentsByCourseService->execute($course_id)), "", 200);
    }
}
