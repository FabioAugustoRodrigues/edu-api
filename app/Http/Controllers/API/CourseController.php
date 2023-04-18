<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\Course\CreateCourseRequest;
use App\Http\Resources\Course\CourseResource;
use App\Services\Course\CreateCourseService;
use Illuminate\Http\Request;

class CourseController extends BaseController
{
    protected $createCourseService;

    public function __construct(
        CreateCourseService $createCourseService
    ) {
        $this->createCourseService = $createCourseService;
    }

    public function store(CreateCourseRequest $request)
    {
        $course = $this->createCourseService->execute($request->validated(), $request->user()->id);

        return $this->sendResponse(new CourseResource($course), "", 201);
    }
}
