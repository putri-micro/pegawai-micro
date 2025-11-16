<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Register</title>

    <link rel="stylesheet" href="{{ asset('assets/plugins/plugins.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.bundle.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body class="bg-light d-flex justify-content-center align-items-center" style="height: 100vh;">

    <form action="{{ route('register.save') }}" method="POST" class="bg-white p-10 rounded-3 shadow w-lg-450px">
        @csrf

        <h2 class="text-center mb-4">Daftar Akun</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Nama --}}
        <div class="mb-4">
            <label class="form-label fw-bold">Nama</label>
            <input type="text" name="nama" value="{{ old('nama') }}" class="form-control" required>
        </div>

        {{-- Username --}}
        <div class="mb-4">
            <label class="form-label fw-bold">Username</label>
            <input type="text" name="username" value="{{ old('username') }}" class="form-control" required>
        </div>

        {{-- Email --}}
        <div class="mb-4">
            <label class="form-label fw-bold">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
        </div>

       {{-- Nomor Telepon --}}
<div class="mb-4">
    <label class="form-label fw-bold">Nomor Telepon</label>
    <input type="text" name="phone" value="{{ old('phone') }}" 
           class="form-control" 
           placeholder="Contoh: 081234567890" 
           required>
    <small class="form-text text-muted">
        Format Indonesia: 08xxx (10-13 digit) atau 62xxx (11-15 digit)
    </small>
    @error('phone')
        <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
</div>

        {{-- Password --}}
        <div class="mb-4 position-relative">
            <label class="form-label fw-bold">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>

            <span class="position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer"
                onclick="togglePassword('password','icon-eye')">
                <i class="bi bi-eye-slash" id="icon-eye"></i>
            </span>
        </div>

        {{-- Konfirmasi Password --}}
        <div class="mb-4 position-relative">
            <label class="form-label fw-bold">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password2" class="form-control" required>

            <span class="position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer"
                onclick="togglePassword('password2','icon-eye2')">
                <i class="bi bi-eye-slash" id="icon-eye2"></i>
            </span>
        </div>

        <button type="submit" class="btn btn-primary w-100 mt-3">Daftar</button>

        <div class="text-center mt-3">
            <a href="{{ route('index') }}">Sudah punya akun? Masuk</a>
        </div>
    </form>

    <script>
        function togglePassword(inputId, iconId) {
            let pass = document.getElementById(inputId);
            let icon = document.getElementById(iconId);

            if (pass.type === "password") {
                pass.type = "text";
                icon.classList.remove("bi-eye-slash");
                icon.classList.add("bi-eye");
            } else {
                pass.type = "password";
                icon.classList.remove("bi-eye");
                icon.classList.add("bi-eye-slash");
            }
        }
    </script>

</body>

</html>
