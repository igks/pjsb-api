<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ContentController;
use App\Http\Controllers\API\ContentDetailController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\UserController;

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

Route::group(['prefix' => 'pjsb-digital/v1'], function () {
    // Authentication
    Route::group(['prefix' => 'auth'], function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);

        Route::group(['middleware' => 'auth:api'], function () {
            Route::post('logout', [AuthController::class, 'logout']);
            Route::post('refresh', [AuthController::class, 'refresh']);
            Route::post('me', [AuthController::class, 'me']);
        });
    });

    // TODO must use api guard
    // User
    Route::resource('users', UserController::class);
    Route::post('users/{id}/activation', [UserController::class, 'activation']);
    // Content
    Route::resource('contents', ContentController::class);
    Route::get('contents/level/{id}', [ContentController::class, 'contentByLevel']);
    Route::get('content/details/{content_id}', [ContentDetailController::class, 'getByContent']);
    Route::post('content/details', [ContentDetailController::class, 'store']);
    Route::put('content/details/{detail_id}', [ContentDetailController::class, 'update']);
    Route::delete('content/details/{detail}', [ContentDetailController::class, 'destroy']);

    // Utils
    Route::group(['prefix' => 'utils'], function () {
        Route::get('roles', [RoleController::class, 'roles']);
    });
});
