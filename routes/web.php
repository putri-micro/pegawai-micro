<?php

use App\Http\Controllers\Content\PortalController;
use App\Http\Controllers\Content\RegisterController;
use App\Http\Controllers\OtpController;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SecureInvoiceController;
use App\Http\Middleware\ValidateEncryptedParameter;
use App\Http\Controllers\InvoiceController;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

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

// High security - single use download
Route::get('/invoices/secure-download/{encryptedId}', [SecureInvoiceController::class, 'secureDownload'])
    ->middleware(['auth', ValidateEncryptedParameter::class . ':secure_download,web'])
    ->name('invoices.secure.download');

// Regular view - reusable token
Route::get('/invoices/view/{encryptedId}', [SecureInvoiceController::class, 'view'])
    ->middleware(['auth', ValidateEncryptedParameter::class . ':view_invoice,web'])
    ->name('invoices.view');

// Generate secure links
Route::get('/invoices/{invoice}/secure-link', [SecureInvoiceController::class, 'generateSecureLink'])
    ->middleware('auth')
    ->name('invoices.generate.secure.link');

// Testing route - HANYA untuk development
Route::get('/test-encryption/{invoice}', function (Invoice $invoice) {
    // High security - single use
    $secureToken = $invoice->getEncryptedParameter(
        'secure_download', 
        'web', 
        Auth::id(),
        15, 
        false
    );

    // Regular use - reusable
    $viewToken = $invoice->getEncryptedParameter('view_invoice');

    // Generate full URL
    $secureUrl = $invoice->getEncryptedUrl(
        'invoices.secure.download',
        'secure_download',
        'web',
        15,
        false
    );

    return [
        'secure_token' => $secureToken,
        'view_token' => $viewToken,
        'secure_url' => $secureUrl,
        'view_url' => route('invoices.view', ['encryptedId' => $viewToken])
    ];
})->middleware('auth');

Route::get('/invoices/{invoice}/links', [InvoiceController::class, 'generateInvoiceLinks'])
    ->middleware('auth')
    ->name('invoices.links');

// HAPUS ATAU COMMENT BARIS BERIKUT:
// Route::get('/invoices/1/links') // Hasil JSON dengan tokens
// Route::get('/invoices/1/secure-link') // Secure URL langsung