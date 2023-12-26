<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\AdminUserController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\WalletController;
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
/*  --------------  Admin --------------  */

Route::get('/admin/login',[AdminController::class,'LoginForm'])->name('admin_login_form');
Route::post('/admin/login/owner',[AdminController::class,'Login'])->name('admin.login');

Route::prefix('admin')->middleware('admin')->group(function(){

    Route::get('/',[AdminController::class,'Dashboard'])->name('admin.home');
    Route::post('/logout',[AdminController::class,'Destroy'])->name('admin.logout');
    Route::get('/admin-user', [AdminUserController::class,'index'])->name('admin-user.index');
    Route::get('/admin-user/create', [AdminUserController::class,'create'])->name('admin-user.create');
    Route::post('/admin-user/create', [AdminUserController::class,'store'])->name('admin-user.store');
    Route::get('/admin-user/{id}/edit',[AdminUserController::class,'edit'])->name('admin-user.edit');
    Route::put('/admin-user/{id}/update',[AdminUserController::class,'update'])->name('admin-user.update');
    Route::delete('/admin-user/{id}',[AdminUserController::class,'destroy'])->name('admin-user.delete');
    Route::get('/admin-user/ssd',[AdminUserController::class,'ssd']);

    Route::get('/user', [UserController::class,'index'])->name('user.index');
    Route::get('/user/create', [UserController::class,'create'])->name('user.create');
    Route::get('/user/create', [UserController::class,'create'])->name('user.create');
    Route::post('/user/create', [UserController::class,'store'])->name('user.store');
    Route::get('/user/{id}/edit',[UserController::class,'edit'])->name('user.edit');
    Route::put('/user/{id}/update',[UserController::class,'update'])->name('user.update');
    Route::delete('/user/{id}',[UserController::class,'destroy'])->name('user.delete');
    Route::get('/user/ssd',[UserController::class,'ssd']);

    Route::get('/wallet',[WalletController::class,'index'])->name('user.wallet');
    Route::get('/wallet/ssd',[WalletController::class,'ssd']);

});





/*  --------------  End Admin --------------  */


require __DIR__.'/auth.php';
