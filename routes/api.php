<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\UserController;

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
Route::prefix('admin')->group(function () {
    Route::post('/invite', [AdminController::class, 'InviteUser']);
});

Route::prefix('user')->group(function () {
    Route::get('/create', [UserController::class, 'CreateUser']);
    Route::post('/store', [UserController::class, 'StoreUser']);
    Route::post('/login', [UserController::class, 'Login']);
    Route::post('/update', [UserController::class, 'UpdateProfile']);
});