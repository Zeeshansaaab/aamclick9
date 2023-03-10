<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [App\Http\Controllers\API\Auth\AuthenticationController::class, 'logout']);
    //Deposit
    // Route::get('deposit', [App\Http\Controllers\FrontEnd\UserController::class, 'index'])->name('referrals.table');
    Route::get('deposit/gateways', [App\Http\Controllers\API\DepositController::class, 'gateways']);
});

Route::post('register', [App\Http\Controllers\API\Auth\AuthenticationController::class, 'register']);
Route::post('login', [App\Http\Controllers\API\Auth\AuthenticationController::class, 'login']);
