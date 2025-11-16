<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\App\Admin;
use App\Models\App\Otp; // ✅ IMPORT OTP
use App\Services\Tools\FileUploadService;
use App\Services\Tools\ResponseService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail; // ✅ IMPORT MAIL
use Carbon\Carbon; // ✅ IMPORT CARBON
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

final class PortalController extends Controller
{
    public function __construct(
        private readonly ResponseService   $responseService,
        private readonly FileUploadService $fileUploadService
    ) {}

    public function login(): View
    {
        if (Auth::guard('admin')->check()) {
            return view('admin.dashboard');
        }

        return view('portal');
    }

    public function logindb(Request $request): RedirectResponse
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $ipAddress = $request->ip();

        $validationRules = [
            'username' => 'required',
            'password' => 'required',
            'g-recaptcha-response' => 'required|captcha',
        ];

        $customMessages = [
            'username.required' => 'Nama Pengguna harus diisi.',
            'password.required' => 'Kata Kunci harus diisi.',
            'g-recaptcha-response.required' => 'Verifikasi reCAPTCHA wajib diisi.',
            'g-recaptcha-response.captcha' => 'Verifikasi reCAPTCHA tidak valid.',
        ];

        $validator = Validator::make($request->all(), $validationRules, $customMessages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Cari user dengan username case-insensitive
        $admin = Admin::whereRaw('LOWER(username) = ?', [strtolower($username)])->first();

        if (!$admin) {
            Log::channel('daily')->warning('Login attempt - user not found', [
                'username' => $username,
                'ip' => $ipAddress
            ]);
            return redirect()->back()->with('error', 'Nama pengguna atau kata sandi salah.');
        }

        // CEK APAKAH AKUN SUDAH VERIFIED - INI YANG DIPERBAIKI
        if (!$admin->is_verified) {
            // Kirim ulang OTP otomatis
            $otp_code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            Otp::where('email', $admin->email)->delete(); // Hapus OTP lama
            Otp::create([
                'email' => $admin->email,
                'otp_code' => $otp_code,
                'expired_at' => Carbon::now()->addMinutes(5),
                'attempts' => 0,
                'is_verified' => 0,
            ]);

            // Kirim email OTP
            try {
                Mail::send('emails.otp', ['nama' => $admin->nama, 'otp' => $otp_code], function($message) use ($admin) {
                    $message->to($admin->email, $admin->nama)
                            ->subject('Kode OTP Verifikasi - SIMPEG UNUJA');
                });
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Akun belum terverifikasi. Gagal mengirim ulang OTP.');
            }

            return redirect()->route('register.otpForm', ['email' => $admin->email])
                            ->with('error', 'Akun belum terverifikasi. Kami telah mengirim ulang kode OTP ke email Anda.');
        }

        // Cek apakah akun terkunci
        if ($admin->isLocked()) {
            $remainingTime = $admin->lock_until->diffForHumans(null, true);
            return redirect()->back()->with('error', "Akun terkunci. Coba lagi dalam {$remainingTime}.");
        }

        // Coba login
        if (Auth::guard('admin')->attempt(['username' => $admin->username, 'password' => $password])) {
            // Reset percobaan gagal
            $admin->resetFailedAttempts();
            
            Log::channel('daily')->info('Login successful', [
                'username' => $username,
                'ip' => $ipAddress
            ]);
            
            return redirect()->intended();
        } else {
            // Tambah percobaan gagal
            $admin->addFailedAttempt();
            
            $remainingAttempts = 5 - $admin->failed_attempt;
            
            Log::channel('daily')->warning('Login failed', [
                'username' => $username,
                'ip' => $ipAddress,
                'failed_attempts' => $admin->failed_attempt
            ]);

            if ($admin->isLocked()) {
                $remainingTime = $admin->lock_until->diffForHumans(null, true);
                return redirect()->back()->with('error', "Terlalu banyak percobaan gagal. Akun terkunci selama {$remainingTime}.");
            }

            return redirect()->back()->with('error', "Nama pengguna atau kata sandi salah. Sisa percobaan: {$remainingAttempts}.");
        }
    }

    public function logout(): RedirectResponse
    {
        Auth::guard('admin')->logout();
        return redirect()->route('index')->with('success', 'Anda telah berhasil keluar.');
    }

    public function error(Request $request): JsonResponse
    {
        $csrfToken = $request->header('X-CSRF-TOKEN');
        if ($csrfToken !== csrf_token()) {
            return $this->responseService->errorResponse('Token CSRF tidak valid.');
        }
        Log::channel('daily')->error('client-error', ['data' => $request->all()]);
        return $this->responseService->successResponse('Error berhasil dicatat.');
    }

    public function viewFile(Request $request, string $dir, string $filename): BinaryFileResponse|StreamedResponse
    {
        return $this->fileUploadService->viewFile($request, $dir, $filename);
    }
}