<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\Course\CreateCourseRequest;
use App\Http\Resources\Course\CourseCollection;
use App\Http\Resources\Course\CourseResource;
use App\Services\Course\CreateCourseService;
use App\Services\Course\GetAllCoursesService;
use App\Services\Course\GetCourseByIdService;
use App\Services\Course\GetCoursesByTeacherService;
use Illuminate\Http\Request;

class CourseController extends BaseController
{
    protected $createCourseService;
    protected $getCoursesByTeacherService;
    protected $getAllCoursesService;
    protected $getCourseByIdService;

    public function __construct(
        CreateCourseService $createCourseService,
        GetCoursesByTeacherService $getCoursesByTeacherService,
        GetAllCoursesService $getAllCoursesService,
        GetCourseByIdService $getCourseByIdService
    ) {
        $this->createCourseService = $createCourseService;
        $this->getCoursesByTeacherService = $getCoursesByTeacherService;
        $this->getAllCoursesService = $getAllCoursesService;
        $this->getCourseByIdService = $getCourseByIdService;
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
}
