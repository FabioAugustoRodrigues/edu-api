<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\Content\CreateContentRequest;
use App\Http\Requests\Content\UpdateContentRequest;
use App\Http\Resources\Content\ContentResource;
use App\Services\Authorization\ContentAuthorizationService;
use App\Services\Content\CreateContentService;
use App\Services\Content\UpdateContentService;

class ContentController extends BaseController
{
    protected $createContentService;
    protected $updateContentService;

    protected $contentAuthorizationService;

    public function __construct(
        CreateContentService $createContentService,
        UpdateContentService $updateContentService,
        ContentAuthorizationService $contentAuthorizationService
    ) {
        $this->createContentService = $createContentService;
        $this->updateContentService = $updateContentService;
        $this->contentAuthorizationService = $contentAuthorizationService;
    }

    public function store(CreateContentRequest $request, $course_id, $lesson_id)
    {
        $this->contentAuthorizationService->store($request->user(), $course_id, $lesson_id);

        $content = $this->createContentService->execute($request->validated(), $lesson_id);

        return $this->sendResponse(new ContentResource($content), "", 201);
    }

    public function update(UpdateContentRequest $request, $course_id, $lesson_id, $id)
    {
        $this->contentAuthorizationService->update($request->user(), $course_id, $lesson_id, $id);

        return $this->sendResponse($this->updateContentService->execute($request->validated(), $id), 200);
    }
}
