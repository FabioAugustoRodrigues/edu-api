<?php

use App\Http\Controllers\API\ContentController;
use App\Http\Controllers\API\CourseController;
use App\Http\Controllers\API\EnrollmentController;
use App\Http\Controllers\API\EnrollmentProgressController;
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
Route::get('/students/me', [StudentController::class, 'me'])->middleware(['auth:sanctum', 'role:student']);
Route::put('/students/me', [StudentController::class, 'updateAuthenticatedStudent'])->middleware(['auth:sanctum', 'role:student']);
Route::delete('/students/me', [StudentController::class, 'deleteAuthenticatedStudent'])->middleware(['auth:sanctum', 'role:student']);
Route::get('/students/{id}/enrollments', [EnrollmentController::class, 'getByStudent']);



// TEACHERS
Route::post('/teachers/register', [TeacherController::class, 'store']);
Route::post('/teachers/login', [TeacherController::class, 'login']);
Route::get('/teachers/me', [TeacherController::class, 'me'])->middleware(['auth:sanctum', 'role:teacher']);
Route::put('/teachers/me', [TeacherController::class, 'updateAuthenticatedTeacher'])->middleware(['auth:sanctum', 'role:teacher']);
Route::delete('/teachers/me', [TeacherController::class, 'deleteAuthenticatedTeacher'])->middleware(['auth:sanctum', 'role:teacher']);
Route::get('/teachers/{id}/courses', [CourseController::class, 'getCoursesByTeacher']);



// COURSES
Route::post('/courses/register', [CourseController::class, 'store'])->middleware(['auth:sanctum', 'role:teacher']);
Route::get('/courses', [CourseController::class, 'getAll']);
Route::get('/courses/{id}', [CourseController::class, 'getById']);
Route::put('/courses/{id}', [CourseController::class, 'update'])->middleware(['auth:sanctum', 'role:teacher']);

Route::get('/courses/{id}/enrollments', [EnrollmentController::class, 'getByCourse'])->middleware(['auth:sanctum', 'role:teacher']);

Route::post('/courses/{id}/lessons/register', [LessonController::class, 'store'])->middleware(['auth:sanctum', 'role:teacher']);
Route::patch('/courses/{id}/lessons/{lesson_id}/name/{name}', [LessonController::class, 'updateName'])->middleware(['auth:sanctum', 'role:teacher']);
Route::put('/courses/{id}/lessons/orders', [LessonController::class, 'updateOrders'])->middleware(['auth:sanctum', 'role:teacher']);
Route::get('/courses/{id}/lessons', [LessonController::class, 'getLessonsByCourse']);

Route::post('/courses/{id}/lessons/{lesson_id}/contents/register', [ContentController::class, 'store'])->middleware(['auth:sanctum', 'role:teacher']);
Route::put('/courses/{id}/lessons/{lesson_id}/contents/{content_id}', [ContentController::class, 'update'])->middleware(['auth:sanctum', 'role:teacher']);
Route::get('/courses/{id}/lessons/{lesson_id}/contents/', [ContentController::class, 'getByLesson'])->middleware(['auth:sanctum', 'role:teacher,student']);

// ENROLLMENTS
Route::post('/enrollments/register', [EnrollmentController::class, 'store'])->middleware(['auth:sanctum', 'role:student']);

Route::post('/enrollments/{id}/progress/register', [EnrollmentProgressController::class, 'store'])->middleware(['auth:sanctum', 'role:student']);