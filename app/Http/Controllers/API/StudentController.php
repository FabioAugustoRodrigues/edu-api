<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
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

    public function store(Request $request)
    {
        $studentArray = [
            "name" => $request->name,
            "email" => $request->email,
            "password" => $request->password
        ];
        $studentAccount = $this->createStudentAccountService->execute($studentArray);

        return $this->sendResponse($studentAccount, "", 201);
    }
}