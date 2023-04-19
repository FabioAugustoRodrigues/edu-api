<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\Course\CreateCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Http\Resources\Course\CourseCollection;
use App\Http\Resources\Course\CourseResource;
use App\Services\Course\CreateCourseService;
use App\Services\Course\GetAllCoursesService;
use App\Services\Course\GetCourseByIdService;
use App\Services\Course\GetCoursesByTeacherService;
use App\Services\Course\UpdateCourseService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class CourseController extends BaseController
{
    protected $createCourseService;
    protected $getCoursesByTeacherService;
    protected $getAllCoursesService;
    protected $getCourseByIdService;
    protected $updateCourseService;

    public function __construct(
        CreateCourseService $createCourseService,
        GetCoursesByTeacherService $getCoursesByTeacherService,
        GetAllCoursesService $getAllCoursesService,
        GetCourseByIdService $getCourseByIdService,
        UpdateCourseService $updateCourseService
    ) {
        $this->createCourseService = $createCourseService;
        $this->getCoursesByTeacherService = $getCoursesByTeacherService;
        $this->getAllCoursesService = $getAllCoursesService;
        $this->getCourseByIdService = $getCourseByIdService;
        $this->updateCourseService = $updateCourseService;
    }

    public function store(CreateCourseRequest $request)
    {
        $course = $this->createCourseService->execute($request->validated(), $request->user()->id);

        return $this->sendResponse(new CourseResource($course), "", 201);
    }

    public function getCoursesByTeacher(Request $request, int $teacher_id)
    {
        return $this->sendResponse(new CourseCollection($this->getCoursesByTeacherService->execute($teacher_id)), 200);
    }

    public function getAll(Request $request)
    {
        return $this->sendResponse(new CourseCollection($this->getAllCoursesService->execute()), 200);
    }

    public function getById(Request $request, $id)
    {
        return $this->sendResponse(new CourseResource($this->getCourseByIdService->execute($id)), 200);
    }

    public function update(UpdateCourseRequest $request, $id)
    {
        if (Gate::denies('teacher-update-post', $id)) {
            $this->sendResponse(['Teacher does not own the course'], 403);
        }

        return $this->sendResponse(new CourseResource($this->updateCourseService->execute($request->validated(), $id)), 200);
    }
}
