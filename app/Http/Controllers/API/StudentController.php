<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\Student\CreateStudentRequest;
use App\Http\Requests\Student\UpdateStudentRequest;
use App\Http\Resources\Student\StudentResource;
use App\Services\Student\CreateStudentAccountService;
use App\Services\Student\DeleteStudentByIdService;
use App\Services\Student\LoginStudentService;
use App\Services\Student\UpdateStudentService;
use Illuminate\Http\Request;

class StudentController extends BaseController
{
    protected $createStudentAccountService;
    protected $loginStudentService;
    protected $updateStudentService;
    protected $deleteStudentByIdService;

    public function __construct(
        CreateStudentAccountService $createStudentAccountService,
        LoginStudentService $loginStudentService,
        UpdateStudentService $updateStudentService,
        DeleteStudentByIdService $deleteStudentByIdService
    ) {
        $this->createStudentAccountService = $createStudentAccountService;
        $this->loginStudentService = $loginStudentService;
        $this->updateStudentService = $updateStudentService;
        $this->deleteStudentByIdService = $deleteStudentByIdService;
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

    public function updateAuthenticatedStudent(UpdateStudentRequest $request)
    {
        return $this->sendResponse($this->updateStudentService->execute($request->validated(), $request->user()->id), "", 200);
    }

    public function deleteAuthenticatedStudent(Request $request)
    {
        return $this->sendResponse($this->deleteStudentByIdService->execute($request->user()->id), "", 200);
    }
}
