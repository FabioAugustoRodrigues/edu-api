<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Services\Teacher\CreateTeacherAccountService;
use Illuminate\Http\Request;

class TeacherController extends BaseController
{
    protected $creeateTeacherAccountService;

    public function __construct(
        CreateTeacherAccountService $creeateTeacherAccountService
    ) {
        $this->creeateTeacherAccountService = $creeateTeacherAccountService;
    }

    public function store(Request $request)
    {
        $teacherArray = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'bio' => $request->bio
        ];

        $teacherAccount = $this->creeateTeacherAccountService->execute($teacherArray);

        return $this->sendResponse($teacherAccount, "", 201);
    }
}
