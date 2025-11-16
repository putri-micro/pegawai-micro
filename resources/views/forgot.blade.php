<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password</title>
    <link rel="stylesheet" href="{{ asset('assets/plugins/plugins.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.bundle.css') }}">
</head>

<body style="background:#f1f4f8;">
<div class="d-flex flex-column flex-root">
    <div class="d-flex flex-center flex-column flex-column-fluid p-10">

        <form class="w-lg-500px bg-white p-10 rounded-3 shadow"
              method="POST"
              action="{{ route('forgot.send') }}">
            @csrf

            <h1 class="text-center mb-10 fw-bold">Lupa Password</h1>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="mb-5">
                <label class="form-label">Masukkan Email Anda</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <button class="btn btn-primary w-100">Kirim OTP</button>

            <div class="mt-4 text-center">
                <a href="{{ route('index') }}">Kembali ke Login</a>
            </div>
        </form>

    </div>
</div>
</body>
</html>
