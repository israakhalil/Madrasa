<?php

use App\Http\Controllers\School\SchoolsController;
use App\Http\Controllers\School\LevelsController;
use App\Http\Controllers\School\ClassesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
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

Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
    Route::post('login', [LoginController::class, 'login']);
});

// Route::group(['prefix' => 'system/settings'], function () {
//     Route::get('index', [SettingController::class, 'index']);
//  });



Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('auth/logout', [LoginController::class, 'logout']);


    // System Routes

        Route::group(['prefix' => 'schools'], function () {
            Route::get('/index', [SchoolsController::class, 'index']);
            Route::get('/create', [SchoolsController::class, 'create']);
            Route::post('/store/{id?}', [SchoolsController::class, 'store']);
            Route::get('{id}/edit', [SchoolsController::class, 'create']);
            Route::delete('{id}/delete', [SchoolsController::class, 'delete']);
            Route::delete('delete-selected', [SchoolsController::class, 'deleteSelected']);
        });

        Route::group(['prefix' => 'levels'], function () {
            Route::get('/index', [LevelsController::class, 'index']);
            Route::get('/create', [LevelsController::class, 'create']);
            Route::post('/store/{id?}', [LevelsController::class, 'store']);
            Route::get('{id}/edit', [LevelsController::class, 'create']);
            Route::delete('{id}/delete', [LevelsController::class, 'delete']);
            Route::delete('delete-selected', [LevelsController::class, 'deleteSelected']);
        });

        Route::group(['prefix' => 'classes'], function () {
            Route::get('/index', [ClassesController::class, 'index']);
            Route::get('/create', [ClassesController::class, 'create']);
            Route::post('/store/{id?}', [ClassesController::class, 'store']);
            Route::get('{id}/edit', [ClassesController::class, 'create']);
            Route::delete('{id}/delete', [ClassesController::class, 'delete']);
            Route::delete('delete-selected', [ClassesController::class, 'deleteSelected']);
        });

});