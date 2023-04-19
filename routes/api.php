<?php

use App\Http\Controllers\API\CourseController;
use App\Http\Controllers\API\EnrollmentController;
use App\Http\Controllers\API\LessonController;
use App\Http\Controllers\API\StudentController;
use App\Http\Controllers\API\TeacherController;
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
Route::put('/students/me', [StudentController::class, 'updateAuthenticatedStudent'])->middleware(['auth:sanctum', 'type.student']);
Route::delete('/students/me', [StudentController::class, 'deleteAuthenticatedStudent'])->middleware(['auth:sanctum', 'type.student']);
Route::get('/students/{id}/enrollments', [EnrollmentController::class, 'getByStudent']);



// TEACHERS
Route::post('/teachers/register', [TeacherController::class, 'store']);
Route::post('/teachers/login', [TeacherController::class, 'login']);
Route::get('/teachers/me', [TeacherController::class, 'me'])->middleware(['auth:sanctum', 'type.teacher']);
Route::put('/teachers/me', [TeacherController::class, 'updateAuthenticatedTeacher'])->middleware(['auth:sanctum', 'type.teacher']);
Route::delete('/teachers/me', [TeacherController::class, 'deleteAuthenticatedTeacher'])->middleware(['auth:sanctum', 'type.teacher']);
Route::get('/teachers/{id}/courses', [CourseController::class, 'getCoursesByTeacher']);



// COURSES
Route::post('/courses/register', [CourseController::class, 'store'])->middleware(['auth:sanctum', 'type.teacher']);
Route::get('/courses', [CourseController::class, 'getAll']);
Route::get('/courses/{id}', [CourseController::class, 'getById']);
Route::put('/courses/{id}', [CourseController::class, 'update'])->middleware(['auth:sanctum', 'type.teacher']);
Route::get('/courses/{id}/enrollments', [EnrollmentController::class, 'getByCourse'])->middleware(['auth:sanctum', 'type.teacher']);

Route::post('/courses/{id}/lessons/register', [LessonController::class, 'store'])->middleware(['auth:sanctum', 'type.teacher']);
Route::get('/courses/{id}/lessons', [LessonController::class, 'getLessonsByCourse']);



// ENROLLMENTS
Route::post('/enrollments/register', [EnrollmentController::class, 'store'])->middleware(['auth:sanctum', 'type.student']);