<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Login — {{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <style>
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Inter", sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0f0f1a;
            overflow: hidden;
        }

        .bg-blob {
            position: fixed;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.35;
            z-index: 0;
            animation: blobFloat 14s ease-in-out infinite alternate;
        }

        .bg-blob.one {
            width: 500px;
            height: 500px;
            background: #1a1a6e;
            top: -10%;
            left: -8%;
        }

        .bg-blob.two {
            width: 400px;
            height: 400px;
            background: #0d4f8c;
            bottom: -12%;
            right: -6%;
            animation-delay: -5s;
        }

        .bg-blob.three {
            width: 340px;
            height: 340px;
            background: #0a7a6e;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: -9s;
        }

        @keyframes blobFloat {
            0% {
                transform: translate(0, 0) scale(1);
            }

            50% {
                transform: translate(30px, -40px) scale(1.08);
            }

            100% {
                transform: translate(-20px, 20px) scale(0.95);
            }
        }

        .card {
            position: relative;
            z-index: 1;
            width: 420px;
            background: rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 48px 40px;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.5);
        }

        .card-header {
            text-align: center;
            margin-bottom: 36px;
        }

        .card-header .icon {
            width: 60px;
            height: 60px;
            border-radius: 18px;
            background: linear-gradient(135deg, #1a5fb4, #0d7a6e);
            box-shadow: 0 8px 25px rgba(26, 95, 180, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            font-size: 26px;
        }

        .card-header h2 {
            font-size: 24px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 6px;
        }

        .card-header p {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.4);
        }

        .badge-admin {
            display: inline-block;
            background: rgba(26, 95, 180, 0.2);
            border: 1px solid rgba(26, 95, 180, 0.4);
            color: #5b9bd5;
            font-size: 11px;
            font-weight: 600;
            padding: 3px 12px;
            border-radius: 50px;
            margin-bottom: 12px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .alert-error {
            background: rgba(233, 69, 144, 0.12);
            border: 1px solid rgba(233, 69, 144, 0.3);
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 12px;
            color: #ff6b9d;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.5);
            margin-bottom: 6px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
            opacity: 0.4;
            pointer-events: none;
        }

        .form-group input {
            width: 100%;
            padding: 13px 16px 13px 42px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.04);
            color: #fff;
            font-family: "Inter", sans-serif;
            font-size: 14px;
            outline: none;
            transition: all 0.3s ease;
        }

        .form-group input::placeholder {
            color: rgba(255, 255, 255, 0.2);
        }

        .form-group input:focus {
            border-color: rgba(26, 95, 180, 0.6);
            background: rgba(255, 255, 255, 0.06);
            box-shadow: 0 0 0 3px rgba(26, 95, 180, 0.15);
        }

        .form-group input.is-invalid {
            border-color: rgba(233, 69, 144, 0.7);
            box-shadow: 0 0 0 3px rgba(233, 69, 144, 0.15);
        }

        .form-extras {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            font-size: 12px;
        }

        .form-extras label {
            display: flex;
            align-items: center;
            gap: 6px;
            color: rgba(255, 255, 255, 0.45);
            cursor: pointer;
        }

        .form-extras label input[type="checkbox"] {
            accent-color: #1a5fb4;
            width: 14px;
            height: 14px;
        }

        .submit-btn {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            font-family: "Inter", sans-serif;
            font-size: 15px;
            font-weight: 600;
            color: #fff;
            cursor: pointer;
            background: linear-gradient(135deg, #1a5fb4, #0d7a6e);
            box-shadow: 0 8px 30px rgba(26, 95, 180, 0.4);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(26, 95, 180, 0.5);
        }

        .submit-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .submit-btn::after {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(transparent, rgba(255, 255, 255, 0.08), transparent);
            transform: rotate(45deg);
            transition: left 0.6s ease;
        }

        .submit-btn:hover::after {
            left: 100%;
        }

        .footer-text {
            text-align: center;
            margin-top: 24px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.25);
        }

        .footer-text a {
            color: #5b9bd5;
            text-decoration: none;
            font-weight: 500;
        }

        .footer-text a:hover {
            color: #8bbde0;
        }

        @media (max-width: 480px) {
            .card {
                width: 92%;
                padding: 36px 24px;
            }
        }
    </style>
</head>

<body>
    <div class="bg-blob one"></div>
    <div class="bg-blob two"></div>
    <div class="bg-blob three"></div>

    <div class="card">
        <div class="card-header">
            <div class="badge-admin">Admin Panel</div>
            <div class="icon">🛡️</div>
            <h2>Welcome Back</h2>
            <p>Sign in to access the control panel</p>
        </div>

        @if ($errors->any())
            <div class="alert-error">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        @if (session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-wrapper">
                    <span class="input-icon">✉️</span>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                        placeholder="admin@example.com" required autofocus autocomplete="email"
                        class="{{ $errors->has('email') ? 'is-invalid' : '' }}" />
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <span class="input-icon">🔑</span>
                    <input id="password" type="password" name="password" placeholder="••••••••" required
                        autocomplete="current-password" />
                </div>
            </div>

            <div class="form-extras">
                <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    Remember me
                </label>
            </div>

            <button type="submit" class="submit-btn">Sign In</button>
        </form>

        <div class="footer-text">
            <a href="{{ url('/') }}">← Back to Store</a>
        </div>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', function() {
            const btn = this.querySelector('.submit-btn');
            btn.disabled = true;
            btn.textContent = 'Signing in...';
        });
    </script>
</body>

</html>
