<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\Student\CreateStudentRequest;
use App\Services\Student\CreateStudentAccountService;
use Illuminate\Http\Request;

class StudentController extends BaseController
{
    protected $createStudentAccountService;

    public function __construct(
        CreateStudentAccountService $createStudentAccountService
    ) {
        $this->createStudentAccountService = $createStudentAccountService;
    }

    public function store(CreateStudentRequest $request)
    {
        $studentAccount = $this->createStudentAccountService->execute($request->validated());

        return $this->sendResponse($studentAccount, "", 201);
    }
}