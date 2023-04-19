<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Services\Lesson\CreateLessonService;
use App\Services\Lesson\GetLessonsByCourseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class LessonController extends BaseController
{
    protected $createLessonService;
    protected $getLessonsByCourseService;

    public function __construct(
        CreateLessonService $createLessonService,
        GetLessonsByCourseService $getLessonsByCourseService
    ) {
        $this->createLessonService = $createLessonService;
        $this->getLessonsByCourseService = $getLessonsByCourseService;
    }

    public function store(Request $request, $course_id)
    {
        if (Gate::denies('teacher-store-course-lessons', $course_id)) {
            $this->sendResponse(['Teacher does not own the course'], 403);
        }

        $lessonArray = [
            'name' => $request->name,
            'lesson_order' => $request->lesson_order
        ];

        return $this->sendResponse($this->createLessonService->execute($lessonArray, $course_id), "", 201);
    }

    public function getLessonsByCourse(Request $request, $course_id)
    {
        return $this->sendResponse($this->getLessonsByCourseService->execute($course_id), "", 200);
    }
}
