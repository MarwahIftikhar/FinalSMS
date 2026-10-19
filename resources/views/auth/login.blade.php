<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Management System - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #172554 0%, #1e40af 50%, #2563eb 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* Animated background */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
            z-index: 1;
        }

        body::after {
            content: '';
            position: fixed;
            bottom: -100px;
            right: -100px;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            animation: float 8s ease-in-out infinite reverse;
            z-index: 1;
        }

        @keyframes float {
            0%, 100% {
                transform: translate(0, 0);
            }
            50% {
                transform: translate(30px, 30px);
            }
        }

        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 
                0 20px 60px rgba(0, 0, 0, 0.3),
                0 0 60px rgba(37, 99, 235, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(10px);
            padding: 50px 40px;
            transform: perspective(1000px) rotateX(0deg);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #172554, #2563eb, #172554);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }
            100% {
                background-position: 1000px 0;
            }
        }

        .login-card:hover {
            box-shadow: 
                0 30px 80px rgba(0, 0, 0, 0.4),
                0 0 80px rgba(37, 99, 235, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.6);
            transform: perspective(1000px) rotateX(-5deg) translateY(-5px);
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
            position: relative;
            z-index: 1;
        }

        .logo-wrapper {
            display: inline-block;
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #172554, #2563eb);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            box-shadow: 0 10px 30px rgba(23, 37, 84, 0.3);
            transform: perspective(1000px) rotateY(0deg);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            0% {
                transform: perspective(1000px) rotateY(0deg) rotateX(0deg);
            }
            100% {
                transform: perspective(1000px) rotateY(360deg) rotateX(0deg);
            }
        }

        .logo-wrapper i {
            font-size: 40px;
            color: #ffffff;
        }

        .login-header h1 {
            color: #172554;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .login-header p {
            color: #64748b;
            font-size: 14px;
            margin: 0;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }

        .form-group label {
            display: block;
            color: #172554;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #f8fafc;
            color: #172554;
        }

        .form-group input:focus {
            outline: none;
            border-color: #2563eb;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-group input::placeholder {
            color: #cbd5e1;
        }

        .form-group select {
            width: 100%;
            padding: 12px 40px 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #f8fafc;
            color: #172554;
            cursor: pointer;
        }

        .form-group select:focus {
            outline: none;
            border-color: #2563eb;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .branch-hint {
            display: block;
            margin-top: 6px;
            font-size: 12px;
            color: #64748b;
        }

        .change-email {
            display: block;
            margin: -10px 0 20px;
            font-size: 12px;
            font-weight: 600;
            color: #2563eb;
            text-decoration: none;
        }

        .change-email:hover {
            color: #172554;
        }

        .form-group i {
            position: absolute;
            right: 12px;
            top: 38px;
            color: #2563eb;
            font-size: 18px;
        }

        .login-button {
            width: 100%;
            padding: 12px 20px;
            background: linear-gradient(135deg, #172554, #2563eb);
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            position: relative;
            overflow: hidden;
            z-index: 1;
            box-shadow: 0 10px 25px rgba(23, 37, 84, 0.2);
        }

        .login-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .login-button:hover::before {
            left: 100%;
        }

        .login-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(23, 37, 84, 0.3);
        }

        .login-button:active {
            transform: translateY(-1px);
        }

        .error-alert {
            background: #fee;
            color: #c33;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            border-left: 4px solid #c33;
            font-size: 14px;
            position: relative;
            z-index: 1;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                transform: translateX(-20px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .login-footer {
            text-align: center;
            margin-top: 20px;
            color: #64748b;
            font-size: 13px;
            position: relative;
            z-index: 1;
        }

        .login-footer a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .login-footer a:hover {
            color: #172554;
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .login-card {
                padding: 40px 24px;
            }

            .login-header h1 {
                font-size: 24px;
            }

            .logo-wrapper {
                width: 70px;
                height: 70px;
            }

            .logo-wrapper i {
                font-size: 35px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="logo-wrapper">
                    <i class="bi bi-building"></i>
                </div>
                <h1>School Management</h1>
                <p>Sign in to your account</p>
            </div>

            @if ($errors->any())
                <div class="error-alert">
                    <strong>Login Failed!</strong><br>
                    {{ $errors->first() }}
                </div>
            @endif

            @if (!request()->query('email'))
                {{-- Step 1: email only — Continue reloads the page with ?email= --}}
                <form method="GET" action="{{ route('login') }}">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Enter your email"
                            required
                            autofocus
                        >
                        <i class="bi bi-envelope"></i>
                    </div>

                    <button type="submit" class="login-button">
                        <i class="bi bi-arrow-right me-2"></i> Continue
                    </button>
                </form>
            @else
                {{-- Step 2: password (plus branch choice for super admin) --}}
                <form method="POST" action="{{ route('login.store') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email', request()->query('email')) }}"
                            required
                        >
                        <i class="bi bi-envelope"></i>
                    </div>

                    <a href="{{ route('login') }}" class="change-email">Use a different email</a>

                    @if ($isSuperAdmin)
                        {{-- Branch select: shown ONLY to super admin --}}
                        <div class="form-group">
                            <label for="branch_id">Branch</label>
                            <select id="branch_id" name="branch_id" class="branch-select">
                                <option value="">Default branch</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }} &mdash; {{ $branch->location }}</option>
                                @endforeach
                            </select>
                            <i class="bi bi-buildings"></i>
                            <small class="branch-hint">Super admin only &mdash; choose which branch to open.</small>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="Enter your password"
                            required
                        >
                        <i class="bi bi-lock"></i>
                    </div>

                    <button type="submit" class="login-button">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Sign In
                    </button>
                </form>
            @endif

            <div class="login-footer">
                <p style="margin: 0;">
                    Need help? Contact your system administrator
                </p>
            </div>
        </div>
    </div>
</body>
</html>

