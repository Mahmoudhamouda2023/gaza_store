<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ config('app.name', 'Laravel') }} — تسجيل الدخول</title>
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

        /* ─── Animated Blobs ─── */
        .bg-blob {
            position: fixed;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.4;
            z-index: 0;
            animation: blobFloat 14s ease-in-out infinite alternate;
        }

        .bg-blob.one {
            width: 520px;
            height: 520px;
            background: #6c3bdb;
            top: -10%;
            left: -8%;
        }

        .bg-blob.two {
            width: 440px;
            height: 440px;
            background: #e94590;
            bottom: -12%;
            right: -6%;
            animation-delay: -5s;
        }

        .bg-blob.three {
            width: 360px;
            height: 360px;
            background: #1dbfe0;
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

        /* ─── Container ─── */
        .container {
            position: relative;
            z-index: 1;
            width: 960px;
            min-height: 580px;
            display: flex;
            border-radius: 24px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.45), inset 0 1px 0 rgba(255, 255, 255, 0.06);
        }

        /* ─── Panels ─── */
        .panel {
            flex: 1;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px 40px;
            transition: opacity 0.6s ease, filter 0.6s ease, transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .panel.login-panel,
        .panel.signup-panel {
            z-index: 2;
        }

        /* ─── Gradient Overlay Sliding Panel ─── */
        .gradient-overlay {
            position: absolute;
            top: 0;
            width: 50%;
            height: 100%;
            z-index: 5;
            pointer-events: none;
            transition: left 0.8s cubic-bezier(0.77, 0, 0.18, 1), opacity 0.8s ease;
        }

        .gradient-overlay .grad-inner {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(108, 59, 219, 0.92) 0%, rgba(233, 69, 144, 0.88) 50%, rgba(29, 191, 224, 0.85) 100%);
            background-size: 300% 300%;
            animation: gradientShift 6s ease infinite;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
            text-align: center;
            color: #fff;
        }

        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .container.login-active .gradient-overlay {
            left: 50%;
        }

        .container.signup-active .gradient-overlay {
            left: 0;
        }

        .container.login-active .signup-panel {
            opacity: 0.15;
            filter: blur(2px);
            transform: scale(0.97);
        }

        .container.signup-active .login-panel {
            opacity: 0.15;
            filter: blur(2px);
            transform: scale(0.97);
        }

        .container.login-active .login-panel,
        .container.signup-active .signup-panel {
            opacity: 1;
            filter: blur(0);
            transform: scale(1);
        }

        /* ─── Overlay Content ─── */
        .overlay-content h2 {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 12px;
            text-shadow: 0 2px 20px rgba(0, 0, 0, 0.3);
        }

        .overlay-content p {
            font-size: 14px;
            line-height: 1.6;
            opacity: 0.9;
            margin-bottom: 28px;
            max-width: 260px;
        }

        .overlay-content .switch-btn {
            padding: 12px 36px;
            border-radius: 50px;
            border: 2px solid rgba(255, 255, 255, 0.7);
            background: transparent;
            color: #fff;
            font-family: "Inter", sans-serif;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
            pointer-events: all;
        }

        .overlay-content .switch-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        /* ─── Sparkles ─── */
        .sparkle {
            position: absolute;
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.6);
            animation: sparkleFloat 4s ease-in-out infinite;
        }

        .sparkle:nth-child(1) {
            top: 15%;
            left: 20%;
            animation-delay: 0s;
        }

        .sparkle:nth-child(2) {
            top: 70%;
            left: 75%;
            animation-delay: 1s;
            width: 3px;
            height: 3px;
        }

        .sparkle:nth-child(3) {
            top: 40%;
            left: 50%;
            animation-delay: 2s;
            width: 5px;
            height: 5px;
        }

        .sparkle:nth-child(4) {
            top: 85%;
            left: 30%;
            animation-delay: 3s;
        }

        .sparkle:nth-child(5) {
            top: 25%;
            left: 80%;
            animation-delay: 1.5s;
            width: 3px;
            height: 3px;
        }

        @keyframes sparkleFloat {

            0%,
            100% {
                opacity: 0;
                transform: translateY(0) scale(1);
            }

            50% {
                opacity: 1;
                transform: translateY(-20px) scale(1.5);
            }
        }

        .divider-line {
            position: absolute;
            left: 50%;
            top: 10%;
            height: 80%;
            width: 1px;
            background: linear-gradient(to bottom, transparent, rgba(255, 255, 255, 0.08) 30%, rgba(255, 255, 255, 0.08) 70%, transparent);
            z-index: 1;
        }

        /* ─── Form Header ─── */
        .form-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .form-header .icon {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            font-size: 24px;
        }

        .login-panel .form-header .icon {
            background: linear-gradient(135deg, #6c3bdb 0%, #9b59b6 100%);
            box-shadow: 0 8px 25px rgba(108, 59, 219, 0.35);
        }

        .signup-panel .form-header .icon {
            background: linear-gradient(135deg, #e94590 0%, #ff6b6b 100%);
            box-shadow: 0 8px 25px rgba(233, 69, 144, 0.35);
        }

        .form-header h2 {
            font-size: 24px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 6px;
        }

        .form-header p {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.45);
        }

        /* ─── Form Groups ─── */
        .form-group {
            width: 100%;
            max-width: 320px;
            margin-bottom: 18px;
            position: relative;
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

        .form-group .input-wrapper {
            position: relative;
        }

        .form-group .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
            opacity: 0.4;
            pointer-events: none;
            transition: opacity 0.3s;
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
            border-color: rgba(108, 59, 219, 0.6);
            background: rgba(255, 255, 255, 0.06);
            box-shadow: 0 0 0 3px rgba(108, 59, 219, 0.15);
        }

        .form-group input.is-invalid {
            border-color: rgba(233, 69, 144, 0.7);
            box-shadow: 0 0 0 3px rgba(233, 69, 144, 0.15);
        }

        /* ─── Validation Errors ─── */
        .error-msg {
            font-size: 11px;
            color: #ff6b9d;
            margin-top: 5px;
            display: block;
        }

        .alert-error {
            width: 100%;
            max-width: 320px;
            background: rgba(233, 69, 144, 0.12);
            border: 1px solid rgba(233, 69, 144, 0.3);
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 12px;
            color: #ff6b9d;
            margin-bottom: 16px;
            text-align: center;
        }

        .alert-success {
            width: 100%;
            max-width: 320px;
            background: rgba(29, 191, 224, 0.12);
            border: 1px solid rgba(29, 191, 224, 0.3);
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 12px;
            color: #1dbfe0;
            margin-bottom: 16px;
            text-align: center;
        }

        /* ─── Extras ─── */
        .form-extras {
            width: 100%;
            max-width: 320px;
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
            accent-color: #6c3bdb;
            width: 14px;
            height: 14px;
        }

        .form-extras a {
            color: #9b7cdb;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .form-extras a:hover {
            color: #c3a6ff;
        }

        /* ─── Submit Button ─── */
        .submit-btn {
            width: 100%;
            max-width: 320px;
            padding: 14px;
            border: none;
            border-radius: 12px;
            font-family: "Inter", sans-serif;
            font-size: 15px;
            font-weight: 600;
            color: #fff;
            cursor: pointer;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            letter-spacing: 0.3px;
        }

        .login-panel .submit-btn {
            background: linear-gradient(135deg, #6c3bdb, #9b59b6);
            box-shadow: 0 8px 30px rgba(108, 59, 219, 0.4);
        }

        .signup-panel .submit-btn {
            background: linear-gradient(135deg, #e94590, #ff6b6b);
            box-shadow: 0 8px 30px rgba(233, 69, 144, 0.4);
        }

        .submit-btn:hover {
            transform: translateY(-2px);
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

        /* ─── Social ─── */
        .social-login {
            margin-top: 24px;
            text-align: center;
            width: 100%;
            max-width: 320px;
        }

        .social-login .divider-text {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.25);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .social-login .divider-text::before,
        .social-login .divider-text::after {
            content: "";
            flex: 1;
            height: 1px;
            background: rgba(255, 255, 255, 0.08);
        }

        .social-icons {
            display: flex;
            gap: 12px;
            justify-content: center;
        }

        .social-icons button {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(255, 255, 255, 0.03);
            color: rgba(255, 255, 255, 0.5);
            font-size: 18px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .social-icons button:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.15);
            color: #fff;
            transform: translateY(-2px);
        }

        /* ─── Mobile ─── */
        .mobile-switch {
            display: none;
            margin-top: 20px;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.4);
        }

        .mobile-switch a {
            color: #9b7cdb;
            text-decoration: none;
            font-weight: 600;
            cursor: pointer;
        }

        @media (max-width:720px) {
            .container {
                flex-direction: column;
                width: 92%;
                min-height: auto;
                max-height: 95vh;
                overflow-y: auto;
            }

            .gradient-overlay {
                display: none !important;
            }

            .divider-line {
                display: none;
            }

            .panel {
                padding: 36px 24px;
                opacity: 1 !important;
                filter: none !important;
                transform: none !important;
            }

            .container.login-active .signup-panel {
                display: none;
            }

            .container.signup-active .login-panel {
                display: none;
            }

            .mobile-switch {
                display: block;
            }
        }
    </style>
</head>

<body>
    <div class="bg-blob one"></div>
    <div class="bg-blob two"></div>
    <div class="bg-blob three"></div>

    {{-- نحدد الحالة الابتدائية: إذا كان فيه أخطاء register نفتح signup تلقائياً --}}
    @php $initMode = session('show_register') || $errors->has('name') ? 'signup-active' : 'login-active'; @endphp

    <div class="container {{ $initMode }}" id="container">

        <div class="divider-line"></div>

        <!-- ─── Sliding Gradient Overlay ─── -->
        <div class="gradient-overlay" id="overlay">
            <div class="grad-inner">
                <span class="sparkle"></span><span class="sparkle"></span>
                <span class="sparkle"></span><span class="sparkle"></span><span class="sparkle"></span>
                <div class="overlay-content">
                    <h2 id="overlayTitle">New Here?</h2>
                    <p id="overlayText">Join us today and unlock a world of possibilities. Create your free account in
                        seconds!</p>
                    <button type="button" class="switch-btn" id="switchBtn" onclick="toggleMode()">Sign Up</button>
                </div>
            </div>
        </div>

        <!-- ════════════════════════════════
             LOGIN PANEL
        ════════════════════════════════ -->
        <div class="panel login-panel">
            <div class="form-header">
                <div class="icon">🔐</div>
                <h2>Welcome Back</h2>
                <p>Sign in to continue your journey</p>
            </div>

            {{-- Session Status (e.g. password reset success) --}}
            @if (session('status'))
                <div class="alert-success">{{ session('status') }}</div>
            @endif

            {{-- Login Errors --}}
            @if ($errors->has('email') && !$errors->has('name'))
                <div class="alert-error">
                    @foreach ($errors->get('email') as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" style="width:100%;display:contents">
                @csrf

                <!-- Email -->
                <div class="form-group">
                    <label for="login_email">Email</label>
                    <div class="input-wrapper">
                        <input id="login_email" type="email" name="email" value="{{ old('email') }}"
                            placeholder="you@example.com" required autofocus autocomplete="username"
                            class="{{ $errors->has('email') && !$errors->has('name') ? 'is-invalid' : '' }}" />
                        <span class="input-icon">✉️</span>
                    </div>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="login_password">Password</label>
                    <div class="input-wrapper">
                        <input id="login_password" type="password" name="password" placeholder="••••••••" required
                            autocomplete="current-password" />
                        <span class="input-icon">🔑</span>
                    </div>
                </div>

                <!-- Remember Me + Forgot Password -->
                <div class="form-extras">
                    <label>
                        <input type="checkbox" name="remember" id="remember_me" {{ old('remember') ? 'checked' : '' }}>
                        Remember me
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Forgot password?</a>
                    @endif
                </div>

                <button type="submit" class="submit-btn">Sign In</button>
            </form>

            <div class="social-login">
                <div class="divider-text">or continue with</div>
                <div class="social-icons">
                    <button type="button" title="Google">G</button>
                    <button type="button" title="Apple">🍎</button>
                    <button type="button" title="GitHub">⌨</button>
                </div>
            </div>

            <div class="mobile-switch">
                Don't have an account? <a onclick="toggleMode()">Sign Up</a>
            </div>
        </div>

        <!-- ════════════════════════════════
             SIGN UP PANEL
        ════════════════════════════════ -->
        <div class="panel signup-panel">
            <div class="form-header">
                <div class="icon">🚀</div>
                <h2>Create Account</h2>
                <p>Start your adventure with us</p>
            </div>

            {{-- Register Errors --}}
            @if ($errors->has('name') || ($errors->has('email') && $errors->has('name')))
                <div class="alert-error">
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" style="width:100%;display:contents">
                @csrf

                <!-- Full Name -->
                <div class="form-group">
                    <label for="reg_name">Full Name</label>
                    <div class="input-wrapper">
                        <input id="reg_name" type="text" name="name" value="{{ old('name') }}"
                            placeholder="John Doe" required autocomplete="name"
                            class="{{ $errors->has('name') ? 'is-invalid' : '' }}" />
                        <span class="input-icon">👤</span>
                    </div>
                    @error('name')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="reg_email">Email</label>
                    <div class="input-wrapper">
                        <input id="reg_email" type="email" name="email" value="{{ old('email') }}"
                            placeholder="you@example.com" required autocomplete="username"
                            class="{{ $errors->has('email') && $errors->has('name') ? 'is-invalid' : '' }}" />
                        <span class="input-icon">✉️</span>
                    </div>
                    @if ($errors->has('name'))
                        @error('email')
                            <span class="error-msg">{{ $message }}</span>
                        @enderror
                    @endif
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="reg_password">Password</label>
                    <div class="input-wrapper">
                        <input id="reg_password" type="password" name="password" placeholder="••••••••" required
                            autocomplete="new-password" />
                        <span class="input-icon">🔑</span>
                    </div>
                    @error('password')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="reg_password_confirmation">Confirm Password</label>
                    <div class="input-wrapper">
                        <input id="reg_password_confirmation" type="password" name="password_confirmation"
                            placeholder="••••••••" required autocomplete="new-password" />
                        <span class="input-icon">🔒</span>
                    </div>
                </div>

                <button type="submit" class="submit-btn">Create Account</button>
            </form>

            <div class="social-login">
                <div class="divider-text">or sign up with</div>
                <div class="social-icons">
                    <button type="button" title="Google">G</button>
                    <button type="button" title="Apple">🍎</button>
                    <button type="button" title="GitHub">⌨</button>
                </div>
            </div>

            <div class="mobile-switch">
                Already have an account? <a onclick="toggleMode()">Sign In</a>
            </div>
        </div>

    </div><!-- /.container -->

    <script>
        // ── تحديد الحالة الابتدائية بناءً على PHP ──
        let isLogin = '{{ $initMode }}' === 'login-active';

        // تحديث نص الـ overlay عند تحميل الصفحة
        updateOverlayText();

        function toggleMode() {
            const container = document.getElementById('container');
            isLogin = !isLogin;
            container.classList.toggle('login-active', isLogin);
            container.classList.toggle('signup-active', !isLogin);
            updateOverlayText();
        }

        function updateOverlayText() {
            document.getElementById('overlayTitle').textContent = isLogin ? 'New Here?' : 'Already have an account?';
            document.getElementById('overlayText').textContent = isLogin ?
                'Join us today and unlock a world of possibilities. Create your free account in seconds!' :
                'Sign in to access your account and continue your journey with us.';
            document.getElementById('switchBtn').textContent = isLogin ? 'Sign Up' : 'Sign In';
        }
    </script>
</body>

</html>
