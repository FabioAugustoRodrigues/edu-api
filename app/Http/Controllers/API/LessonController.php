<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\Lesson\LessonCollection;
use App\Http\Resources\Lesson\LessonResource;
use App\Services\Lesson\CreateLessonService;
use App\Services\Lesson\GetLessonsByCourseService;
use App\Services\Lesson\UpdateLessonNameService;
use App\Services\Lesson\UpdateLessonOrdersService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class LessonController extends BaseController
{
    protected $createLessonService;
    protected $getLessonsByCourseService;
    protected $updateLessonNameService;
    protected $updateLessonOrdersService;

    public function __construct(
        CreateLessonService $createLessonService,
        GetLessonsByCourseService $getLessonsByCourseService,
        UpdateLessonNameService $updateLessonNameService,
        UpdateLessonOrdersService $updateLessonOrdersService
    ) {
        $this->createLessonService = $createLessonService;
        $this->getLessonsByCourseService = $getLessonsByCourseService;
        $this->updateLessonNameService = $updateLessonNameService;
        $this->updateLessonOrdersService = $updateLessonOrdersService;
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

        return $this->sendResponse(new LessonResource($this->createLessonService->execute($lessonArray, $course_id)), "", 201);
    }

    public function getLessonsByCourse(Request $request, $course_id)
    {
        return $this->sendResponse(new LessonCollection($this->getLessonsByCourseService->execute($course_id)), "", 200);
    }

    public function updateName(Request $request, $course_id, $lesson_id, $name)
    {
        if (empty($name) || strlen($name) > 255) {
            return $this->sendResponse(null, 'Invalid name.', 400);
        }

        if (Gate::denies('teacher-update-lesson-name', $course_id)) {
            return $this->sendResponse(null, 'Teacher does not own the course', 403);
        }

        return $this->sendResponse($this->updateLessonNameService->execute($lesson_id, $name), "", 200);
    }

    public function updateOrders(Request $request, $course_id)
    {
        $lesson_orders = $request->input("lesson_orders");

        if (Gate::denies('teacher-update-lesson-orders', [$course_id, $lesson_orders])) {
            return $this->sendResponse(null, 'Teacher does not own the course', 403);
        }

        return $this->sendResponse($this->updateLessonOrdersService->execute($lesson_orders), "", 200);
    }
}
