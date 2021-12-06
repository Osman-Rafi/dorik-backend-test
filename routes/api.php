<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TeachersController;
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

Route::post('/auth/register', [AuthController::class, 'register']);

Route::post('/auth/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('me', function () {
        return auth()->user();
    });
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::post('/create-teacher', [AdminController::class, 'createTeacher']);
    Route::post('/create-classroom', [TeachersController::class, 'createClassroom']);
    Route::delete('/end-classroom/{id}', [TeachersController::class, 'endClassroom']);

    Route::post('/create-post', [TeachersController::class, 'createPost']);
});

