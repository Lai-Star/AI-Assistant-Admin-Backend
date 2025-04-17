<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\CompanyController;
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
});
