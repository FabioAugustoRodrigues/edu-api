<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\Course\CreateCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Http\Resources\Course\CourseCollection;
use App\Http\Resources\Course\CourseResource;
use App\Services\Authorization\CourseAuthorizationService;
use App\Services\Course\CreateCourseService;
use App\Services\Course\GetAllCoursesService;
use App\Services\Course\GetCourseByIdService;
use App\Services\Course\GetCoursesByTeacherService;
use App\Services\Course\UpdateCourseService;
use Illuminate\Http\Request;

class CourseController extends BaseController
{
    protected $createCourseService;
    protected $getCoursesByTeacherService;
    protected $getAllCoursesService;
    protected $getCourseByIdService;
    protected $updateCourseService;

    protected $courseAuthorizationService;

    public function __construct(
        CreateCourseService $createCourseService,
        GetCoursesByTeacherService $getCoursesByTeacherService,
        GetAllCoursesService $getAllCoursesService,
        GetCourseByIdService $getCourseByIdService,
        UpdateCourseService $updateCourseService,
        CourseAuthorizationService $courseAuthorizationService
    ) {
        $this->createCourseService = $createCourseService;
        $this->getCoursesByTeacherService = $getCoursesByTeacherService;
        $this->getAllCoursesService = $getAllCoursesService;
        $this->getCourseByIdService = $getCourseByIdService;
        $this->updateCourseService = $updateCourseService;
        $this->courseAuthorizationService = $courseAuthorizationService;
    }

    public function store(CreateCourseRequest $request)
    {
        $course = $this->createCourseService->execute($request->validated(), $request->user()->id);

        return $this->sendResponse(new CourseResource($course), "", 201);
    }

    public function getCoursesByAuthenticatedTeacher(Request $request)
    {
        $perPage = $request->query('per_page', 5);
        $page = $request->query('page', 1);

        return $this->sendResponse(
            new CourseCollection(
                $this->getCoursesByTeacherService->execute($request->user()->id, $perPage, $page)
            ),
            200
        );
    }

    public function getCoursesByTeacher(Request $request, int $teacher_id)
    {
        $perPage = $request->query('per_page', 5);
        $page = $request->query('page', 1);

        return $this->sendResponse(
            new CourseCollection(
                $this->getCoursesByTeacherService->execute($teacher_id, $perPage, $page)
            ),
            200
        );
    }

    public function getAll(Request $request)
    {
        $perPage = $request->query('per_page', 5);
        $page = $request->query('page', 1);

        return $this->sendResponse(
            new CourseCollection(
                $this->getAllCoursesService->execute($perPage, $page)
            ),
            200
        );
    }

    public function getById(Request $request, $id)
    {
        return $this->sendResponse(new CourseResource($this->getCourseByIdService->execute($id)), 200);
    }

    public function update(UpdateCourseRequest $request, $id)
    {
        $this->courseAuthorizationService->update($request->user(), $id);

        return $this->sendResponse(new CourseResource($this->updateCourseService->execute($request->validated(), $id)), 200);
    }
}
