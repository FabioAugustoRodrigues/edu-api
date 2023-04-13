<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\Student\CreateStudentRequest;
use App\Http\Resources\Student\StudentResource;
use App\Services\Student\CreateStudentAccountService;
use App\Services\Student\LoginStudentService;
use Illuminate\Http\Request;

class StudentController extends BaseController
{
    protected $createStudentAccountService;
    protected $loginStudentService;

    public function __construct(
        CreateStudentAccountService $createStudentAccountService,
        LoginStudentService $loginStudentService
    ) {
        $this->createStudentAccountService = $createStudentAccountService;
        $this->loginStudentService = $loginStudentService;
    }

    public function store(CreateStudentRequest $request)
    {
        $studentAccount = $this->createStudentAccountService->execute($request->validated());

        return $this->sendResponse(new StudentResource($studentAccount), "", 201);
    }

    public function login(Request $request)
    {
        return $this->sendResponse($this->loginStudentService->execute($request->email, $request->password), "", 200);
    }

    public function me(Request $request)
    {
        return $this->sendResponse($request->user(), "", 200);
    }
}
