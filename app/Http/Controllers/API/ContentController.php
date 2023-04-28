<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\Content\CreateContentRequest;
use App\Http\Resources\Content\ContentResource;
use App\Services\Authorization\ContentAuthorizationService;
use App\Services\Content\CreateContentService;

class ContentController extends BaseController
{
    protected $createContentService;

    protected $contentAuthorizationService;

    public function __construct(
        CreateContentService $createContentService,
        ContentAuthorizationService $contentAuthorizationService
    ) {
        $this->createContentService = $createContentService;
        $this->contentAuthorizationService = $contentAuthorizationService;
    }

    public function store(CreateContentRequest $request, $course_id, $lesson_id)
    {
        $this->contentAuthorizationService->store($request->user(), $course_id, $lesson_id);

        $content = $this->createContentService->execute($request->validated(), $lesson_id);

        return $this->sendResponse(new ContentResource($content), "", 201);
    }
}
