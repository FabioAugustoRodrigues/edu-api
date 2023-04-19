<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\Teacher\CreateTeacherRequest;
use App\Http\Requests\Teacher\UpdateTeacherRequest;
use App\Http\Resources\Teacher\TeacherResource;
use App\Services\Teacher\CreateTeacherAccountService;
use App\Services\Teacher\DeleteTeacherByIdService;
use App\Services\Teacher\LoginTeacherService;
use App\Services\Teacher\UpdateTeacherService;
use Illuminate\Http\Request;

class TeacherController extends BaseController
{
    protected $createTeacherAccountService;
    protected $loginTeacherService;
    protected $updateTeacherService;
    protected $deleteTeacherByIdService;

    public function __construct(
        CreateTeacherAccountService $createTeacherAccountService,
        LoginTeacherService $loginTeacherService,
        UpdateTeacherService $updateTeacherService,
        DeleteTeacherByIdService $deleteTeacherByIdService
    ) {
        $this->createTeacherAccountService = $createTeacherAccountService;
        $this->loginTeacherService = $loginTeacherService;
        $this->updateTeacherService = $updateTeacherService;
        $this->deleteTeacherByIdService = $deleteTeacherByIdService;
    }

    public function store(CreateTeacherRequest $request)
    {
        $teacherAccount = $this->createTeacherAccountService->execute($request->validated());

        return $this->sendResponse(new TeacherResource($teacherAccount), "", 201);
    }

    public function login(Request $request)
    {
        return $this->sendResponse($this->loginTeacherService->execute($request->email, $request->password), "", 200);
    }

    public function me(Request $request)
    {
        return $this->sendResponse($request->user(), "", 200);
    }

    public function updateAuthenticatedTeacher(UpdateTeacherRequest $request)
    {
        return $this->sendResponse($this->updateTeacherService->execute($request->validated(), $request->user()->id), "", 200);
    }

    public function deleteAuthenticatedTeacher(Request $request)
    {
        return $this->sendResponse($this->deleteTeacherByIdService->execute($request->user()->id), "", 200);
    }
}
