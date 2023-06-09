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

    public function getByStudent(Request $request)
    {
        $searchParams = $request->only(['status']);

        $perPage = $request->query('per_page', 5);
        $page = $request->query('page', 1);

        return $this->sendResponse(
            new EnrollmentCollection(
                $this->getEnrollmentsByStudentService->execute($request->user()->id, $perPage, $page, $searchParams)
            ),
            "",
            200
        );
    }

    public function getByCourse(Request $request, $course_id)
    {
        $this->enrollmentAuthorizationService->view($request->user(), $course_id);

        $perPage = $request->query('per_page', 5);
        $page = $request->query('page', 1);

        return $this->sendResponse(
            new EnrollmentCollection(
                $this->getEnrollmentsByCourseService->execute($course_id, $perPage, $page)
            ),
            "",
            200
        );
    }
}
