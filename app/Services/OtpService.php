<?php

namespace App\Services;

use App\Models\App\Otp;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class OtpService
{
    public function generateOtp(string $email): Otp
    {
        // Hapus OTP lama yang belum diverifikasi
        Otp::where('email', $email)->where('is_verified', false)->delete();

        // Buat OTP baru
        $otp = Otp::create([
            'email' => $email,
            'otp_code' => str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT),
            'expired_at' => Carbon::now()->addMinutes(5),
        ]);

        // Kirim via email
        Mail::send('emails.otp', ['otp' => $otp->otp_code], function ($message) use ($email) {
            $message->to($email)
                ->subject('Kode OTP Anda (SIMPEG Universitas Nurul Jadid)');
        });

        return $otp;
    }

    public function verifyOtp(string $email, string $inputOtp): string
    {
        $otp = Otp::where('email', $email)->latest()->first();

        if (!$otp) {
            return 'OTP tidak ditemukan.';
        }

        if ($otp->isExpired()) {
            return 'OTP sudah kedaluwarsa.';
        }

        if ($otp->attempts >= 5) {
            return 'Anda telah melebihi batas percobaan. Coba lagi setelah 5 menit.';
        }

        if ($otp->otp_code !== $inputOtp) {
            $otp->increment('attempts');
            return 'OTP salah. Percobaan ke-' . $otp->attempts . '/5';
        }

        $otp->update(['is_verified' => true]);
        return 'OTP berhasil diverifikasi.';
    }

    public function maskEmail(string $email): string
    {
        [$local, $domain] = explode('@', $email);

        // Local part masking
        $maskedLocal = substr($local, 0, 2) . '**' . substr($local, -2);

        // Domain masking
        $domainParts = explode('.', $domain);
        foreach ($domainParts as $i => &$part) {
            if ($i === 0) {
                $part = substr($part, 0, 2) . '**';
            } elseif ($i < count($domainParts) - 1) {
                $part = '.' . substr($part, 0, 1) . '*';
            } else {
                $part = '.' . substr($part, 0, 1);
            }
        }
        $maskedDomain = implode('', $domainParts);

        return $maskedLocal . '@' . ltrim($maskedDomain, '.');
    }
}
