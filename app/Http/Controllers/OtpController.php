<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OtpService;

class OtpController extends Controller
{
    public function __construct(private OtpService $otpService) {}

    public function requestOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $otp = $this->otpService->generateOtp($request->email);
        $maskedEmail = $this->otpService->maskEmail($request->email);

        return response()->json([
            'message' => 'OTP telah dikirim ke email: ' . $maskedEmail,
            'expires_in' => '5 menit',
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp_code' => 'required|digits:6'
        ]);

        $result = $this->otpService->verifyOtp($request->email, $request->otp_code);

        return response()->json(['message' => $result]);
    }
}
