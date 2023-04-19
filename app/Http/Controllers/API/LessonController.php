<?php

namespace App\Http\Controllers\API;

use App\Helpers\Authorization\CourseAuthorization;
use App\Http\Controllers\API\BaseController;
use App\Services\Lesson\CreateLessonService;
use Illuminate\Http\Request;

class LessonController extends BaseController
{
    protected $createLessonService;

    public function __construct(
        CreateLessonService $createLessonService
    ) {
        $this->createLessonService = $createLessonService;
    }

    public function store(Request $request, $course_id)
    {
        $authorization = new CourseAuthorization();
        $authorization->validateOwnership($request->user()->id, $course_id);

        $lessonArray = [
            'name' => $request->name,
            'lesson_order' => $request->lesson_order
        ];

        return $this->sendResponse($this->createLessonService->execute($lessonArray, $course_id), "", 201);
    }
}
