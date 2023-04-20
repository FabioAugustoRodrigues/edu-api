<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\Enrollment\EnrollmentCollection;
use App\Http\Resources\Enrollment\EnrollmentResource;
use App\Services\Enrollment\CreateEnrollmentService;
use App\Services\Enrollment\GetEnrollmentsByCourseService;
use App\Services\Enrollment\GetEnrollmentsByStudentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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

        return $this->sendResponse(new EnrollmentResource($this->createEnrollmentService->execute($student_id, $course_id)), "", 201);
    }

    public function getByStudent(Request $request, $student_id)
    {
        return $this->sendResponse(new EnrollmentCollection($this->getEnrollmentsByStudentService->execute($student_id)), "", 200);
    }

    public function getByCourse(Request $request, $course_id)
    {
        if (Gate::denies('teacher-view-course-enrollments', $course_id)) {
            return $this->sendResponse(['Teacher does not own the course'], 403);
        }

        return $this->sendResponse(new EnrollmentCollection($this->getEnrollmentsByCourseService->execute($course_id)), "", 200);
    }
}
