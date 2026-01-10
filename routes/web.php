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

use App\Http\Controllers\Admin\Absensi\AbsenJenisController;
use App\Http\Controllers\Admin\Absensi\AbsensiController;
use App\Http\Controllers\Admin\Absensi\AbsensiDetailController;
use App\Http\Controllers\Admin\Gaji\GajiPeriodeController;
use App\Http\Controllers\Admin\Gaji\GajiUmumController;
use App\Http\Controllers\Admin\Gaji\KomponenGajiController;
use App\Http\Controllers\Admin\Gaji\TarifLemburController;
use App\Http\Controllers\Admin\Gaji\TarifPotonganController;
use App\Http\Controllers\Admin\Gaji\GajiJabatanController;
use App\Http\Controllers\Admin\Gaji\GajiTrxController;
use App\Http\Controllers\Admin\Gaji\GajiDetailController;

// AbsenJenis routes
Route::prefix('absensi')->group(function () {
    Route::controller(AbsenJenisController::class)->prefix('jenis-absensi')->group(function () {
        Route::get('/', 'index')->name('admin.absensi.jenis_absensi.index');
        Route::get('/list', 'list')->name('admin.absensi.jenis_absensi.list');
        Route::post('/', 'store')->name('admin.absensi.jenis_absensi.store');
        Route::get('/{id}', 'show')->name('admin.absensi.jenis_absensi.show');
        Route::put('/{id}', 'update')->name('admin.absensi.jenis_absensi.update');
        Route::delete('/{id}', 'destroy')->name('admin.absensi.jenis_absensi.destroy');
    });

    Route::controller(AbsensiController::class)->prefix('data-absensi')->group(function () {
        Route::get('/', 'index')->name('admin.absensi.absensi.index');
        Route::get('/list', 'list')->name('admin.absensi.absensi.list');
        Route::post('/', 'store')->name('admin.absensi.absensi.store');
        Route::get('/dropdown/jadwal', 'getJadwalDropdown')->name('admin.absensi.absensi.dropdown.jadwal');
        Route::get('/{id}', 'show')->name('admin.absensi.absensi.show');
        Route::put('/{id}', 'update')->name('admin.absensi.absensi.update');
        Route::delete('/{id}', 'destroy')->name('admin.absensi.absensi.destroy');
    });

    Route::controller(AbsensiDetailController::class)->prefix('detail-absensi')->group(function () {
        Route::get('/', 'index')->name('admin.absensi.absensi_detail.index');
        Route::get('/list', 'list')->name('admin.absensi.absensi_detail.list');
        Route::get('/dropdown/absensi', 'getAbsensiDropdown')->name('admin.absensi.absensi_detail.dropdown.absensi');
        Route::get('/dropdown/jenis-absen', 'getJenisAbsenDropdown')->name('admin.absensi.absensi_detail.dropdown.jenis_absen');
        Route::post('/', 'store')->name('admin.absensi.absensi_detail.store');
        Route::get('/{id}', 'show')->name('admin.absensi.absensi_detail.show');
        Route::put('/{id}', 'update')->name('admin.absensi.absensi_detail.update');
        Route::delete('/{id}', 'destroy')->name('admin.absensi.absensi_detail.destroy');
    });
});

// GajiPeriode routes
Route::prefix('gaji')->group(function () {
    Route::controller(GajiPeriodeController::class)->prefix('gaji-periode')->group(function () {
        Route::get('/', 'index')->name('admin.gaji.gaji_periode.index');
        Route::get('/list', 'list')->name('admin.gaji.gaji_periode.list');
        Route::post('/', 'store')->name('admin.gaji.gaji_periode.store');
        Route::get('/{id}', 'show')->name('admin.gaji.gaji_periode.show');
        Route::put('/{id}', 'update')->name('admin.gaji.gaji_periode.update');
        Route::delete('/{id}', 'destroy')->name('admin.gaji.gaji_periode.destroy');
    });

    Route::controller(GajiUmumController::class)->prefix('gaji-umum')->group(function () {
        Route::get('/', 'index')->name('admin.gaji.gaji_umum.index');
        Route::get('/list', 'list')->name('admin.gaji.gaji_umum.list');
        Route::post('/', 'store')->name('admin.gaji.gaji_umum.store');
        Route::get('/{id}', 'show')->name('admin.gaji.gaji_umum.show');
        Route::put('/{id}', 'update')->name('admin.gaji.gaji_umum.update');
        Route::delete('/{id}', 'destroy')->name('admin.gaji.gaji_umum.destroy');
    });

    Route::controller(KomponenGajiController::class)->prefix('komponen-gaji')->group(function () {
        Route::get('/', 'index')->name('admin.gaji.komponen_gaji.index');
        Route::get('/list', 'list')->name('admin.gaji.komponen_gaji.list');
        Route::post('/', 'store')->name('admin.gaji.komponen_gaji.store');
        Route::get('/{id}', 'show')->name('admin.gaji.komponen_gaji.show');
        Route::put('/{id}', 'update')->name('admin.gaji.komponen_gaji.update');
        Route::delete('/{id}', 'destroy')->name('admin.gaji.komponen_gaji.destroy');
    });

    Route::controller(TarifLemburController::class)->prefix('tarif-lembur')->group(function () {
        Route::get('/', 'index')->name('admin.gaji.tarif_lembur.index');
        Route::get('/list', 'list')->name('admin.gaji.tarif_lembur.list');
        Route::post('/', 'store')->name('admin.gaji.tarif_lembur.store');
        Route::get('/{id}', 'show')->name('admin.gaji.tarif_lembur.show');
        Route::put('/{id}', 'update')->name('admin.gaji.tarif_lembur.update');
        Route::delete('/{id}', 'destroy')->name('admin.gaji.tarif_lembur.destroy');
    });

    Route::controller(TarifPotonganController::class)->prefix('tarif-potongan')->group(function () {
        Route::get('/', 'index')->name('admin.gaji.tarif_potongan.index');
        Route::get('/list', 'list')->name('admin.gaji.tarif_potongan.list');
        Route::post('/', 'store')->name('admin.gaji.tarif_potongan.store');
        Route::get('/{id}', 'show')->name('admin.gaji.tarif_potongan.show');
        Route::put('/{id}', 'update')->name('admin.gaji.tarif_potongan.update');
        Route::delete('/{id}', 'destroy')->name('admin.gaji.tarif_potongan.destroy');
    });

    Route::controller(GajiJabatanController::class)->prefix('gaji-jabatan')->group(function () {
        Route::get('/', 'index')->name('admin.gaji.gaji_jabatan.index');
        Route::get('/list', 'list')->name('admin.gaji.gaji_jabatan.list');
        Route::post('/', 'store')->name('admin.gaji.gaji_jabatan.store');
        Route::get('/{id}', 'show')->name('admin.gaji.gaji_jabatan.show');
        Route::put('/{id}', 'update')->name('admin.gaji.gaji_jabatan.update');
        Route::delete('/{id}', 'destroy')->name('admin.gaji.gaji_jabatan.destroy');
    });

    Route::controller(GajiTrxController::class)->prefix('gaji-trx')->group(function () {
        Route::get('/', 'index')->name('admin.gaji.gaji_trx.index');
        Route::get('/list', 'list')->name('admin.gaji.gaji_trx.list');
        Route::post('/', 'store')->name('admin.gaji.gaji_trx.store');
        Route::get('/{id}', 'show')->name('admin.gaji.gaji_trx.show');
        Route::put('/{id}', 'update')->name('admin.gaji.gaji_trx.update');
        Route::delete('/{id}', 'destroy')->name('admin.gaji.gaji_trx.destroy');
    });

    Route::controller(GajiDetailController::class)->prefix('gaji-detail')->group(function () {
        Route::get('/', 'index')->name('admin.gaji.gaji_detail.index');
        Route::get('/list', 'list')->name('admin.gaji.gaji_detail.list');
        Route::post('/', 'store')->name('admin.gaji.gaji_detail.store');
        Route::get('/{id}', 'show')->name('admin.gaji.gaji_detail.show');
        Route::put('/{id}', 'update')->name('admin.gaji.gaji_detail.update');
        Route::delete('/{id}', 'destroy')->name('admin.gaji.gaji_detail.destroy');
    });
});


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
        'view_url' => route('invoices.view', ['encryptedId' => $viewToken])
    ];
})->middleware('auth');

Route::get('/invoices/{invoice}/links', [InvoiceController::class, 'generateInvoiceLinks'])
    ->middleware('auth')
    ->name('invoices.links');

// HAPUS ATAU COMMENT BARIS BERIKUT:
// Route::get('/invoices/1/links') // Hasil JSON dengan tokens
// Route::get('/invoices/1/secure-link') // Secure URL langsung