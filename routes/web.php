<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AdminAuthenticatedSessionController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Frontend\NotificationController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('auth')->group(function(){
    Route::get('/',[PageController::class,'index'])->name('home');
    Route::get('/wallet',[PageController::class,'wallet'])->name('wallet');
    Route::get('/account_profile',[PageController::class,'profile'])->name('account_profile');
    Route::get('/change_password',[PageController::class,'changePassword'])->name('change_password');
    Route::post('/change_password',[PageController::class,'changePasswordStore'])->name('change_password_store');
    Route::get('/transfer',[PageController::class,'transfer'])->name('transfer');
    Route::get('/check_phone_number',[PageController::class,'checkPhone'])->name('check_phone_number');
    Route::post('/transfer_confirmation',[PageController::class,'transferConfirmation'])->name('transfer_confirmation');
    Route::get('/check_password',[PageController::class,'checkPassword'])->name('check_password');
    Route::post('/transfer_complete',[PageController::class,'transferComplete'])->name('transfer_complete');
    Route::get('/transaction',[PageController::class,'transaction'])->name('transaction');
    Route::get('/transaction_detail/{transaction_id}',[PageController::class,'transactionDetail'])->name('transaction_detail');
    Route::get('/receive_qr',[PageController::class,'receiveQR'])->name('receive_qr');
    Route::get('/scan_pay',[PageController::class,'scanQR'])->name('scan_qr');
    Route::get('/scan_pay_form',[PageController::class,'scanPayForm'])->name('scan_pay_form');
    Route::post('/scan_pay_confirmation',[PageController::class,'scanPayConfirmation'])->name('scan_pay_confirmation');
    Route::post('/scan_complete',[PageController::class,'scanPayComplete'])->name('scan_complete');
    Route::get('/notification',[NotificationController::class,'index'])->name('notification');
    Route::get('/notification_detail/{id}',[NotificationController::class,'show'])->name('notification_detail');


});

Route::get('test',[PageController::class,'test']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
