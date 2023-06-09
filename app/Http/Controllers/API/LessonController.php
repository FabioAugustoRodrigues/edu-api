<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\Lesson\CreateLessonRequest;
use App\Http\Resources\Lesson\LessonCollection;
use App\Http\Resources\Lesson\LessonResource;
use App\Services\Authorization\LessonAuthorizationService;
use App\Services\Lesson\CreateLessonService;
use App\Services\Lesson\GetLessonsByCourseService;
use App\Services\Lesson\UpdateLessonNameService;
use App\Services\Lesson\UpdateLessonOrdersService;
use Illuminate\Http\Request;

class LessonController extends BaseController
{
    protected $createLessonService;
    protected $getLessonsByCourseService;
    protected $updateLessonNameService;
    protected $updateLessonOrdersService;

    protected $lessonAuthorizationService;

    public function __construct(
        CreateLessonService $createLessonService,
        GetLessonsByCourseService $getLessonsByCourseService,
        UpdateLessonNameService $updateLessonNameService,
        UpdateLessonOrdersService $updateLessonOrdersService,
        LessonAuthorizationService $lessonAuthorizationService
    ) {
        $this->createLessonService = $createLessonService;
        $this->getLessonsByCourseService = $getLessonsByCourseService;
        $this->updateLessonNameService = $updateLessonNameService;
        $this->updateLessonOrdersService = $updateLessonOrdersService;
        $this->lessonAuthorizationService = $lessonAuthorizationService;
    }

    public function store(CreateLessonRequest $request, $course_id)
    {
        $this->lessonAuthorizationService->store($request->user(), $course_id);

        return $this->sendResponse(new LessonResource($this->createLessonService->execute($request->validated(), $course_id)), "", 201);
    }

    public function getLessonsByCourse(Request $request, $course_id)
    {
        $perPage = $request->query('per_page', 5);
        $page = $request->query('page', 1);

        return $this->sendResponse(
            new LessonCollection(
                $this->getLessonsByCourseService->execute($course_id, $perPage, $page)
            ),
            "",
            200
        );
    }

    public function updateName(Request $request, $course_id, $lesson_id, $name)
    {
        if (empty($name) || strlen($name) > 255) {
            return $this->sendResponse(null, 'Invalid name.', 400);
        }

        $this->lessonAuthorizationService->updateName($request->user(), $course_id, $lesson_id);

        return $this->sendResponse($this->updateLessonNameService->execute($lesson_id, $name), "", 200);
    }

    public function updateOrders(Request $request, $course_id)
    {
        $lesson_orders = $request->input("lesson_orders");

        $this->lessonAuthorizationService->updateOrders($request->user(), $course_id, $lesson_orders);

        return $this->sendResponse($this->updateLessonOrdersService->execute($lesson_orders), "", 200);
    }
}
