<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\App\Admin;
use App\Models\App\Otp;
use App\Services\ValidationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log; // ✅ IMPORT LOG
use Carbon\Carbon;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register');
    }

    public function save(Request $request)
    {
        // Validasi input dasar
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'username' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Validasi custom
        $usernameError = ValidationService::validateUsername($request->username);
        $passwordError = ValidationService::validatePassword($request->password);
        $emailError = ValidationService::validateEmail($request->email);
        $phoneError = ValidationService::validatePhone($request->phone);

        $errors = [];
        if ($usernameError) $errors['username'] = $usernameError;
        if ($passwordError) $errors['password'] = $passwordError;
        if ($emailError) $errors['email'] = $emailError;
        if ($phoneError) $errors['phone'] = $phoneError;

        // Cek username unik (case-insensitive) - exclude unverified accounts
        $existingUsername = Admin::whereRaw('LOWER(username) = ?', [strtolower($request->username)])
                                ->where('is_verified', 1)
                                ->first();
        if ($existingUsername) {
            $errors['username'] = 'Username sudah digunakan';
        }

        // Handle email yang sudah terdaftar tapi belum verified
        $existingEmail = Admin::where('email', $request->email)->first();
        if ($existingEmail) {
            if ($existingEmail->is_verified) {
                $errors['email'] = 'Email sudah terdaftar';
            } else {
                $existingEmail->delete();
                Otp::where('email', $request->email)->delete();
            }
        }

        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors)->withInput();
        }

        // Generate id_admin
        $lastAdmin = Admin::orderBy('id_admin', 'desc')->first();
        $newId = 'ADM' . str_pad($lastAdmin ? ((int)substr($lastAdmin->id_admin, 3) + 1) : 1, 4, '0', STR_PAD_LEFT);

        // Simpan admin (belum verified)
        $admin = Admin::create([
            'id_admin' => $newId,
            'nama' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'is_verified' => 0,
            'failed_attempt' => 0,
        ]);

        // Generate OTP
        $otp_code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Hapus OTP lama
        Otp::where('email', $admin->email)->delete();

        // Buat OTP baru
        Otp::create([
            'email' => $admin->email,
            'otp_code' => $otp_code,
            'expired_at' => Carbon::now()->addMinutes(5),
            'attempts' => 0,
            'is_verified' => 0,
        ]);

        // ✅ PERBAIKAN: KIRIM EMAIL OTP DENGAN FALLBACK
        try {
            Mail::send('emails.otp', ['nama' => $admin->nama, 'otp' => $otp_code], function($message) use ($admin) {
                $message->to($admin->email, $admin->nama)
                        ->subject('Kode OTP Registrasi SIMPEG UNUJA');
            });
            $emailSent = true;
        } catch (\Exception $e) {
            Log::error('Failed to send OTP email: ' . $e->getMessage()); // ✅ PERBAIKI: Log bukan \log
            $emailSent = false;
        }

        // ✅ PERBAIKAN: FALLBACK - Simpan OTP di session untuk ditampilkan jika email gagal
        session(['manual_otp_' . $admin->email => $otp_code]);

        return redirect()->route('register.otpForm', ['email' => $admin->email])
                        ->with('success', 'Registrasi berhasil. Silakan cek email untuk kode OTP.')
                        ->with('email_sent', $emailSent); // Kirim status email
    }

    public function otpForm($email)
    {
        $maskedEmail = ValidationService::maskEmail($email);
        return view('otp', ['email' => $email, 'maskedEmail' => $maskedEmail]);
    }

    public function verifyOtp(Request $request, $email)
    {
        $request->validate([
            'otp' => 'required|digits:6'
        ]);

        $otp = Otp::where('email', $email)
                  ->where('expired_at', '>', Carbon::now())
                  ->first();

        if (!$otp) {
            return redirect()->back()->withErrors(['otp' => 'Kode OTP tidak ditemukan atau sudah expired.']);
        }

        // Cek apakah melebihi batas percobaan
        if ($otp->isMaxAttemptsExceeded()) {
            $waitTime = $otp->expired_at->addMinutes(5)->diffForHumans(null, true);
            return redirect()->back()->withErrors(['otp' => "Terlalu banyak percobaan. Coba lagi dalam {$waitTime}."]);
        }

        // Cek OTP
        if ($otp->otp_code !== $request->otp) {
            $otp->increment('attempts');
            $remaining = max(0, 5 - $otp->attempts);
            return redirect()->back()->withErrors(['otp' => "Kode OTP salah. Sisa percobaan: {$remaining}."]);
        }

        // OTP benar - verifikasi admin
        $otp->update(['is_verified' => 1]);
        Admin::where('email', $email)->update(['is_verified' => 1]);

        // Hapus OTP yang sudah digunakan
        $otp->delete();

        return redirect()->route('index')->with('success', 'Registrasi berhasil! Akun Anda sudah aktif. Silakan login.');
    }
}