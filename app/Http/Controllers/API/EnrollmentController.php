<?php

namespace App\Http\Controllers\API;

use App\Helpers\Authorization\CourseAuthorization;
use App\Http\Controllers\API\BaseController;
use App\Services\Enrollment\CreateEnrollmentService;
use App\Services\Enrollment\GetEnrollmentsByCourseService;
use App\Services\Enrollment\GetEnrollmentsByStudentService;
use Illuminate\Http\Request;

class EnrollmentController extends BaseController
{
    protected $createEnrollmentService;
    protected $getEnrollmentsByStudentService;
    protected $getEnrollmentsByCourseService;

    public function __construct(
        CreateEnrollmentService $createEnrollmentService,
        GetEnrollmentsByStudentService $getEnrollmentsByStudentService,
        GetEnrollmentsByCourseService $getEnrollmentsByCourseService
    ) {
        $this->createEnrollmentService = $createEnrollmentService;
        $this->getEnrollmentsByStudentService = $getEnrollmentsByStudentService;
        $this->getEnrollmentsByCourseService = $getEnrollmentsByCourseService;
    }

    public function store(Request $request)
    {
        $student_id = $request->user()->id;
        $course_id = $request->course_id;

        return $this->sendResponse($this->createEnrollmentService->execute($student_id, $course_id), "", 201);
    }

    public function getByStudent(Request $request, $student_id)
    {
        return $this->sendResponse($this->getEnrollmentsByStudentService->execute($student_id), "", 200);
    }

    public function getByCourse(Request $request, $course_id)
    {
        $authorization = new CourseAuthorization();
        $authorization->validateOwnership($request->user()->id, $course_id);

        return $this->sendResponse($this->getEnrollmentsByCourseService->execute($course_id), "", 200);
    }
}
