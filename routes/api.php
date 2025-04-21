<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserGroupController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'App\Http\Controllers\Api\AuthController@login');
    Route::post('logout', 'App\Http\Controllers\Api\AuthController@logout');
    // Route::post('refresh', 'App\Http\Controllers\Api\AuthController@refresh');
    // Route::post('check', 'App\Http\Controllers\Api\AuthController@check');

    // Route::post('password/forgot', 'App\Http\Controllers\Api\AuthController@forgotPassword');
    // Route::post('password/check/token', 'App\Http\Controllers\Api\AuthController@checkToken');
    // Route::post('password/reset', 'App\Http\Controllers\Api\AuthController@resetPassword');
});

Route::group([
    'middleware' => 'auth:api'
], function () {
    Route::group([
        'prefix' => 'companies'
    ], function () {
        Route::get('/all', [CompanyController::class, 'index']);
        Route::post('/save', [CompanyController::class, 'save']);
        Route::delete('/${id}', [CompanyController::class, 'destroy']);
        Route::get('/{id}', [CompanyController::class, 'show']);
    });

    Route::group([
        'prefix' => 'users'
    ], function () {
        Route::get('/all', [UserController::class, 'index']);
        Route::post('/save', [UserController::class, 'save']);
        Route::delete('/${id}', [UserController::class, 'destroy']);
        Route::get('/{id}', [UserController::class, 'show']);
    });

    Route::group([
        'prefix' => 'user-group'
    ], function () {
        Route::get('/all', [UserGroupController::class, 'index']);
        Route::post('/save', [UserGroupController::class, 'save']);
        Route::delete('/${id}', [UserGroupController::class, 'destroy']);
        Route::get('/{id}', [UserGroupController::class, 'show']);
    });
});
