<?php

use App\Http\Controllers\School\SchoolsController;
use App\Http\Controllers\School\LevelsController;
use App\Http\Controllers\School\ClassesController;
use App\Http\Controllers\School\StudentsController;
use App\Http\Controllers\Constants\ConstantsController;
use App\Http\Controllers\Procedures\AbsencesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Procedures\BooksController;
use App\Http\Controllers\Procedures\DelaysController;
use App\Http\Controllers\Procedures\LeavesController;
use App\Http\Controllers\Procedures\ViolationsController;

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
        });

        Route::group(['prefix' => 'levels'], function () {
            Route::get('/index', [LevelsController::class, 'index']);
            Route::get('/create', [LevelsController::class, 'create']);
            Route::post('/store/{id?}', [LevelsController::class, 'store']);
            Route::get('{id}/edit', [LevelsController::class, 'create']);
            Route::delete('{id}/delete', [LevelsController::class, 'delete']);
        });

        Route::group(['prefix' => 'classes'], function () {
            Route::get('/index', [ClassesController::class, 'index']);
            Route::get('/create', [ClassesController::class, 'create']);
            Route::post('/store/{id?}', [ClassesController::class, 'store']);
            Route::get('{id}/edit', [ClassesController::class, 'create']);
            Route::delete('{id}/delete', [ClassesController::class, 'delete']);
        });

        
        Route::group(['prefix' => 'students'], function () {
            Route::get('/index', [StudentsController::class, 'index']);
            Route::get('/create', [StudentsController::class, 'create']);
            Route::post('/store', [StudentsController::class, 'store']);
            Route::get('{id}/edit', [StudentsController::class, 'create']);
            Route::delete('{id}/delete', [StudentsController::class, 'delete']);
        });

        Route::group(['prefix' => 'constants'], function () {
            Route::get('/absenceTypes', [ConstantsController::class, 'absenceTypes']);
            Route::get('/violationDegrees', [ConstantsController::class, 'violationDegrees']);
            Route::get('/violationProcedures', [ConstantsController::class, 'violationProcedures']);       
        });
        Route::group(['prefix' => 'absences'], function () {
            Route::post('/store', [AbsencesController::class, 'store']);
        });
        Route::group(['prefix' => 'delays'], function () {
            Route::post('/store', [DelaysController::class, 'store']);
        });
        Route::group(['prefix' => 'books'], function () {
            Route::post('/store', [BooksController::class, 'store']);
        });
        Route::group(['prefix' => 'violations'], function () {
            Route::post('/store', [ViolationsController::class, 'store']);
        });
        Route::group(['prefix' => 'leaves'], function () {
            Route::post('/store', [LeavesController::class, 'store']);
        });

});