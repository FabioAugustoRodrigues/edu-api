<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\Teacher\TeacherResource;
use App\Services\Teacher\CreateTeacherAccountService;
use App\Services\Teacher\LoginTeacherService;
use Illuminate\Http\Request;

class TeacherController extends BaseController
{
    protected $createTeacherAccountService;
    protected $loginTeacherService;

    public function __construct(
        CreateTeacherAccountService $createTeacherAccountService,
        LoginTeacherService $loginTeacherService
    ) {
        $this->createTeacherAccountService = $createTeacherAccountService;
        $this->loginTeacherService = $loginTeacherService;
    }

    public function store(Request $request)
    {
        $teacherArray = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'bio' => $request->bio
        ];

        $teacherAccount = $this->createTeacherAccountService->execute($teacherArray);

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
}
