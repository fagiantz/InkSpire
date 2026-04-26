<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration - InkSpire</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #FEFEFD;
        }

        .input-icon-wrapper {
            position: relative;
        }

        .input-icon-wrapper .icon-left {
            position: absolute;
            top: 50%;
            left: 14px;
            transform: translateY(-50%);
            color: #38BDF8;
            z-index: 10;
            font-size: 1rem;
        }

        .input-icon-wrapper .icon-eye {
            position: absolute;
            top: 50%;
            right: 14px;
            transform: translateY(-50%);
            color: #979CA6;
            cursor: pointer;
            z-index: 10;
            font-size: 1rem;
        }

        .input-icon-wrapper .form-control {
            width: 332px;
            /* <-- panjang input 332px */
            padding-left: 2.5rem;
            /* ruang untuk ikon kiri */
            padding-right: 2.5rem;
            /* ruang untuk ikon kanan */
            border-color: #38BDF8;
            border-radius: 50px;
            border-width: 1.5px;
            box-sizing: border-box;
            /* pastikan padding tidak menambah lebar */
        }

        .input-icon-wrapper .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(56, 189, 248, 0.25);
            border-color: #38BDF8;
        }

        .btn-daftar {
            background-color: #38BDF8;
            border-color: #38BDF8;
            color: white;
            font-weight: 700;
            border-radius: 50px;
            width: 332px;
            height: 48px;
            font-size: 1rem;
        }

        .btn-daftar:hover {
            background-color: #0ea5e9;
            border-color: #0ea5e9;
            color: white;
        }
    </style>
</head>

<body>
    <main class="container">
        <div class="row justify-content-center min-vh-100 align-items-center">
            <!-- Kolom lebih lebar agar card mencukupi untuk input 332px + padding 107px kiri‑kanan -->
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-sm rounded-4" style="border: 2px solid #38BDF8;">
                    <!-- Padding kiri 107px dan kanan 107px, atas‑bawah py‑5 -->
                    <div class="card-body py-5" style="padding-left: 107px; padding-right: 107px;">

                        <h3 class="fw-bold text-left mb-4">Registrasi</h3>

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form method="POST" action="/register">
                            @csrf

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <div class="input-icon-wrapper">
                                    <i class="bi bi-envelope-fill icon-left"></i>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="email@example.com" required autofocus>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">Password</label>
                                <div class="input-icon-wrapper">
                                    <i class="bi bi-lock-fill icon-left"></i>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="masukkan kata sandi" required>
                                    <i class="bi bi-eye-fill icon-eye" id="togglePasswordIcon1"
                                        onclick="togglePassword('password', 'togglePasswordIcon1')"></i>
                                </div>
                            </div>

                            <!-- Konfirmasi Password -->
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi
                                    Password</label>
                                <div class="input-icon-wrapper">
                                    <i class="bi bi-lock-fill icon-left"></i>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" placeholder="masukkan kata sandi" required>
                                    <i class="bi bi-eye-fill icon-eye" id="togglePasswordIcon2"
                                        onclick="togglePassword('password_confirmation', 'togglePasswordIcon2')"></i>
                                </div>
                            </div>

                            <!-- Tombol Daftar -->
                            <div class="mt-4">
                                <button type="submit" class="btn btn-daftar">Daftar</button>
                            </div>
                        </form>

                        <div class="text-center mt-3">
                            <small>Sudah punya akun? <a href="/login" style="color: #38BDF8;">Login di sini</a></small>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye-fill');
                icon.classList.add('bi-eye-slash-fill');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash-fill');
                icon.classList.add('bi-eye-fill');
            }
        }
    </script>
</body>

</html>
