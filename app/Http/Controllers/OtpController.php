<?php

namespace App\Http\Controllers;

use App\Models\App\Admin;
use App\Models\App\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OtpController extends Controller
{
    public function forgotPage()
    {
        return view('forgot');
    }

    public function forgotSendOtp(Request $request) // ✅ PERBAIKI: 'forgotSendOrg' jadi 'forgotSendOtp'
    {
        $request->validate(['email' => 'required|email']);
        
        $user = Admin::where('email', $request->email)->first();
        if (!$user) {
            return back()->with('error', 'Email tidak terdaftar.');
        }

        // Generate OTP
        $otpCode = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Hapus OTP lama
        Otp::where('email', $request->email)->delete();
        
        // Buat OTP baru
        Otp::create([
            'email' => $request->email,
            'otp_code' => $otpCode,
            'expired_at' => Carbon::now()->addMinutes(5),
            'attempts' => 0,
            'is_verified' => false,
        ]);

        // ✅ PERBAIKAN: Tambahkan fallback system sama seperti register
        try {
            Mail::send('emails.otp', ['otp' => $otpCode, 'nama' => $user->nama], function ($m) use ($request, $user) {
                $m->to($request->email, $user->nama)
                  ->subject('OTP Reset Password SIMPEG UNUJA');
            });
            $emailSent = true; // ✅ PERBAIKI: 'emailsent' jadi 'emailSent'
        } catch (\Exception $e) { // ✅ PERBAIKI: 'Exception' jadi '\Exception'
            Log::error('Failed to send forgot password OTP: ' . $e->getMessage());
            $emailSent = false;
        }

        // ✅ FALLBACK: Simpan OTP di session
        session(['manual_otp_' . $request->email => $otpCode]);
        session(['reset_email' => $request->email]); // ✅ PERBAIKI: tambah tanda petik penutup

        return redirect()->route('reset.otp.page')
                        ->with('success', 'OTP telah dikirim ke email Anda.')
                        ->with('email_sent', $emailSent); // Status pengiriman email
    }

    public function resetOtpPage()
{
    $email = session('reset_email');
    if (!$email) {
        return redirect()->route('forgot.page')->with('error', 'Session expired.');
    }
    
    // ✅ DEBUG: Tampilkan OTP manual di log
    $manualOtp = session('manual_otp_' . $email);
     Log::info("Manual OTP for {$email}: {$manualOtp}");
    
    return view('reset-otp');
}

    public function resetOtpVerify(Request $request)
{
    $request->validate(['otp' => 'required|digits:6']);

    $email = session('reset_email');
    if (!$email) {
        return redirect()->route('forgot.page')->with('error', 'Session expired.');
    }

    $otp = Otp::where('email', $email)->first();
    if (!$otp) {
        return back()->with('error', 'OTP tidak ditemukan. Silakan request OTP baru.');
    }

    // Cek expired
    if ($otp->isExpired()) {
        $otp->delete(); // Hapus OTP yang expired
        return back()->with('error', 'OTP sudah kadaluarsa. Silakan request OTP baru.');
    }

    // Cek batas percobaan
    if ($otp->attempts >= 5) {
        $waitTime = $otp->expired_at->addMinutes(5)->diffForHumans(null, true);
        return back()->with('error', "Terlalu banyak percobaan. Coba lagi dalam {$waitTime}.");
    }

    // Verifikasi OTP
    if ($otp->otp_code !== $request->otp) {
        $otp->increment('attempts');
        $remaining = max(0, 5 - $otp->attempts);
        return back()->with('error', "OTP salah. Sisa percobaan: {$remaining}.");
    }

    // OTP valid
    $otp->delete();
    return redirect()->route('reset.password.page')->with('success', 'OTP valid. Silakan set password baru.');
}

    public function resetPasswordPage()
    {
        if (!session('reset_email')) {
            return redirect()->route('forgot.page')->with('error', 'Session expired.');
        }
        return view('reset-password');
    }

    public function resetPasswordSave(Request $request)
{
    try {
        // Validasi sangat sederhana
        $request->validate([
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
        ]);

        $email = session('reset_email');
        
        if (!$email) {
            return redirect()->route('forgot.page')->with('error', 'Session habis. Silakan mulai ulang.');
        }

        // Update password langsung
        DB::table('admin')->where('email', $email)->update([
            'password' => Hash::make($request->password)
        ]);

        // Hapus session
        session()->forget('reset_email');

        return redirect()->route('index')->with('success', 'Password berhasil direset! Silakan login.');

    } catch (\Exception $e) {
        Log::error('RESET PASSWORD ERROR: ' . $e->getMessage());
        return back()->with('error', 'Error: ' . $e->getMessage());
    }
}
}