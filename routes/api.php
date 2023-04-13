<?php

use App\Http\Controllers\API\StudentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// STUDENTS
Route::post('/students/register', [StudentController::class, 'store']);
Route::post('/students/login', [StudentController::class, 'login']);
Route::get('/students/me', [StudentController::class, 'me'])->middleware(['auth:sanctum', 'type.student']);