<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi OTP</title>
    <link rel="stylesheet" href="{{ asset('assets/plugins/plugins.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.bundle.css') }}">
</head>

<body style="background:#f1f4f8;">
<div class="d-flex flex-column flex-root">
    <div class="d-flex flex-center flex-column flex-column-fluid p-10">

        <form class="w-lg-500px bg-white p-10 rounded-3 shadow"
              method="POST"
              action="{{ route('reset.otp.verify') }}">
            @csrf

            <h1 class="text-center mb-10 fw-bold">Verifikasi OTP</h1>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <!-- ✅ FALLBACK UNTUK TAMPILKAN OTP MANUAL -->
            @php
                $resetEmail = session('reset_email');
            @endphp

            @if(!session('email_sent') && session('manual_otp_' . $resetEmail))
                <div class="alert alert-warning">
                    <h5>📧 Email gagal dikirim! Gunakan kode OTP berikut:</h5>
                    <h3 class="text-center text-danger my-3">{{ session('manual_otp_' . $resetEmail) }}</h3>
                    <small>Kode ini hanya berlaku 5 menit</small>
                </div>
            @else
                <p class="text-center">OTP dikirim ke: <b>{{ $resetEmail }}</b></p>
                @if(!session('email_sent'))
                    <div class="alert alert-info">
                        <small>Jika OTP tidak masuk di email, refresh halaman ini untuk melihat OTP manual.</small>
                    </div>
                @endif
            @endif

            <div class="mb-5">
                <label class="form-label">Masukkan 6-digit Kode OTP</label>
                <input type="text" maxlength="6" name="otp" class="form-control" 
                       pattern="[0-9]{6}" required placeholder="123456">
                @error('otp')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <button class="btn btn-primary w-100">Verifikasi</button>

            <div class="text-center mt-3">
                <a href="{{ route('forgot.page') }}">Kirim ulang OTP</a>
            </div>
        </form>

    </div>
</div>
</body>
</html>