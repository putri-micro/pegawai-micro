<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="{{ asset('assets/plugins/plugins.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.bundle.css') }}">
</head>

<body style="background:#f1f4f8;">
<div class="d-flex flex-column flex-root">
    <div class="d-flex flex-center flex-column flex-column-fluid p-10">

        <form class="w-lg-500px bg-white p-10 rounded-3 shadow"
              method="POST"
              action="{{ route('reset.password.save') }}">
            @csrf

            <h1 class="text-center mb-10 fw-bold">Reset Password</h1>

            <div class="mb-5">
                <label class="form-label">Password Baru</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-5">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button class="btn btn-primary w-100">Simpan Password Baru</button>

        </form>

    </div>
</div>
</body>
</html>
