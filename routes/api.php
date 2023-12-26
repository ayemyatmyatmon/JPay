<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PageController;
use Illuminate\Support\Facades\Auth;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('Api')->group(function(){
    Route::post('register',[AuthController::class,'register'])->name('register');
    Route::post('login',[AuthController::class,'login'])->name('login');
    Route::middleware('auth:api')->group(function(){
        Route::get('profile',[PageController::class,'profile'])->name('profile');
        Route::post('logout',[PageController::class,'logout'])->name('logout');
        Route::post('transfer',[PageController::class,'transfer'])->name('transfer');
        Route::get('transaction',[PageController::class,'transaction'])->name('transaction');
        Route::get('transaction/{transaction_id}',[PageController::class,'transactionDetail'])->name('transaction_detail');
        Route::get('notification',[PageController::class,'notification'])->name('notification');
        Route::get('notification/{notification_id}',[PageController::class,'notificationDetail'])->name('notification_detail');

    });

});