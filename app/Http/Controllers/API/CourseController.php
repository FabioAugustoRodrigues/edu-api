<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
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

    public function store(Request $request)
    {
        $courseArray = [
            'teacher_id' => $request->user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => $request->start_date
        ];

        $course = $this->createCourseService->execute($courseArray);

        return $this->sendResponse($course, "", 201);
    }
}
