<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QrDbController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\QrPreview;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetPassword;

Route::get('/qr/{id}', [QrPreview::class , 'qr_preview']);

Route::get('/test' , [Controller::class, 'test']);
Route::get('/send' , [Controller::class, 'send_mail']);

Route::get('/pending-users' , [AdminController::class , 'pending_users'])->name('pending-users')->middleware('isLogged');
Route::get('/user-approve/{id}' , [AdminController::class , 'user_approve']);
Route::get('/user-reject/{id}' , [AdminController::class , 'user_reject']);
Route::get('/active-users' , [AdminController::class , 'active_users'])->middleware('isLogged');
Route::get('/admin-profile' , [AdminController::class , 'profile'])->name('admin_profile')->middleware('isLogged');
Route::post('/admin-profile_update' , [AdminController::class , 'update_profile'])->name('admin_update_profile_information')->middleware('isLogged');
Route::post('/admin_update_password' , [AdminController::class , 'update_password'])->name('admin_update_password')->middleware('isLogged');



Route::get('/' , [LoginController::class, 'login'])->name('login')->middleware('isAlreadyLogged');
Route::get('/login' , [LoginController::class, 'login'])->name('login')->middleware('isAlreadyLogged');
Route::post('/login-user' , [LoginController::class, 'login_user'])->name('login-user');

Route::get('/register' , [RegisterController::class, 'register'])->name('register')->middleware('isAlreadyLogged');
Route::post('/register-user' , [RegisterController::class, 'register_user'])->name('register-user');
Route::get('/verify-user/{id}/{token}' , [RegisterController::class, 'verify_user'])->name('verify-user');

Route::get('/reset-password' , [ResetPassword::class, 'search_email'])->name('reset-password');
Route::post('/reset-password' , [ResetPassword::class, 'send_resetPass_email'])->name('find-password-to-reset');
Route::get('/reset/{email}' , [ResetPassword::class, 'reset_password'])->name('pass-reset-form');
Route::post('/set-password' , [ResetPassword::class, 'set_new_password'])->name('set-new-password');

Route::get('/logout' , [LoginController::class, 'logout'])->name('logout');


Route::resource('qrcodes', 'App\Http\Controllers\QRCodeController');
Route::get('/dynamic-qr-generator', [QrDbController::class, 'generator'])->name('qr_generator')->middleware('isLogged');
Route::post('/store-qr' , [QrDbController::class, 'store_qr'])->name('store-qr');
Route::get('/qr-generated/{id}', [QrDbController::class, 'qr_generated'])->name('qr_generated')->middleware('isLogged');
Route::get('/qr-list', [QrDbController::class , 'qr_list'])->name('qr-list')->middleware('isLogged');
Route::get('/qr-preview/{id}', [QrDbController::class, 'qr_preview'])->name('qr_preview')->middleware('isLogged');
Route::get('/qr-edit/{id}', [QrDbController::class, 'qr_edit'])->name('qr_edit')->middleware('isLogged');
Route::post('/url-change', [QrDbController::class, 'url_change'])->name('change_url')->middleware('isLogged');
Route::get('/user-profile' , [QrDbController::class, 'profile'])->name('user_profile');
