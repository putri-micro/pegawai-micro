<?php

use App\Http\Controllers\Content\PortalController;
use App\Http\Controllers\Content\RegisterController;
use App\Http\Controllers\OtpController;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortalController::class, 'login'])->name('index');
Route::post('/login', [PortalController::class, 'logindb'])->name('logindb');
Route::get('/logout', [PortalController::class, 'logout'])->name('logout');

Route::get('log-viewer', [LogViewerController::class, 'index'])->name('log-viewer');
Route::post('log-error', [PortalController::class, 'error'])->name('log-error');

// Register + OTP
Route::get('/register', [RegisterController::class, 'index'])->name('register.page');
Route::post('/register', [RegisterController::class, 'save'])->name('register.save');

Route::get('/otp/{email}', [RegisterController::class, 'otpForm'])->name('register.otpForm');
Route::post('/otp/{email}', [RegisterController::class, 'verifyOtp'])->name('register.verifyOtp');

// Forgot / Reset
Route::get('/forgot-password', [OtpController::class, 'forgotPage'])->name('forgot.page');
Route::post('/forgot-password', [OtpController::class, 'forgotSendOtp'])->name('forgot.send');

Route::get('/reset-otp', [OtpController::class, 'resetOtpPage'])->name('reset.otp.page');
Route::post('/reset-otp', [OtpController::class, 'resetOtpVerify'])->name('reset.otp.verify');

Route::get('/reset-password', [OtpController::class, 'resetPasswordPage'])->name('reset.password.page');
Route::post('/reset-password', [OtpController::class, 'resetPasswordSave'])->name('reset.password.save');