<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\Content\CreateContentRequest;
use App\Http\Resources\Content\ContentResource;
use App\Services\Content\CreateContentService;
use Illuminate\Support\Facades\Gate;

class ContentController extends BaseController
{
    protected $createContentService;

    public function __construct(
        CreateContentService $createContentService
    ) {
        $this->createContentService = $createContentService;
    }

    public function store(CreateContentRequest $request, $course_id, $lesson_id)
    {
        if (Gate::denies('teacher-store-content-lessons', [$course_id, $lesson_id])) {
            return $this->sendResponse(null, 'Teacher does not own the course', 403);
        }

        $content = $this->createContentService->execute($request->validated(), $lesson_id);

        return $this->sendResponse(new ContentResource($content), "", 201);
    }
}
