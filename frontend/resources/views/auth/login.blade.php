<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - InkSpire</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: radial-gradient(circle at center, #edf2fc 0%, #dbe3f5 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .login-card {
            background-color: #ffffff;
            border-radius: 24px;
            padding: 48px 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 20px 40px rgba(37, 99, 235, 0.08), 0 10px 20px rgba(37, 99, 235, 0.04);
            border: none;
        }

        .brand-title {
            color: #2563EB;
            font-size: 2.25rem;
            font-weight: 800;
            text-align: center;
            margin-bottom: 6px;
            letter-spacing: -0.03em;
        }

        .brand-subtitle {
            color: #64748B;
            font-size: 0.875rem;
            font-weight: 500;
            text-align: center;
            margin-bottom: 36px;
        }

        .form-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #1E293B;
            margin-bottom: 8px;
        }

        .form-control {
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.875rem;
            color: #0F172A;
            transition: all 0.2s ease;
            height: auto;
        }

        .form-control::placeholder {
            color: #94A3B8;
        }

        .form-control:focus {
            border-color: #3B82F6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            outline: none;
        }

        .btn-login {
            background-color: #2563EB;
            border: none;
            color: #ffffff;
            font-weight: 600;
            border-radius: 12px;
            padding: 12px 48px;
            font-size: 0.95rem;
            display: block;
            margin: 32px auto 0 auto;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
        }

        .btn-login:hover {
            background-color: #1D4ED8;
            color: white;
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.25);
            transform: translateY(-1px);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .register-text {
            text-align: center;
            margin-top: 28px;
            font-size: 0.875rem;
            color: #64748B;
        }

        .register-link {
            color: #2563EB;
            font-weight: 700;
            text-decoration: none;
            margin-left: 4px;
        }

        .register-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="login-card">
        <h1 class="brand-title">InkSpire</h1>
        <p class="brand-subtitle">Website Custom Printing Modern</p>

        @if (session('error'))
            <div class="alert alert-danger mb-4 py-2 px-3 rounded-3" style="font-size: 0.85rem;">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control w-100" id="email" name="email" placeholder="example@email.com"
                    required autofocus>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control w-100" id="password" name="password"
                    placeholder="Masukkan password" required>
            </div>

            <!-- Tombol Login -->
            <button type="submit" class="btn btn-login">Login</button>
        </form>

        <!-- <div class="register-text">
            Belum punya akun? <a href="/register" class="register-link">Daftar</a>
        </div> -->
    </div>
    @include('partials.footer')
</body>

</html>