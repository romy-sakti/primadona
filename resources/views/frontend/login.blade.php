@extends('frontend.layout.app')

@section('title', 'Login Portal PRIMADONA')

@section('content')
    <!-- Page banner Area -->
    <div class="page-banner bg-1">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="container">
                    <div class="page-content">
                        <h2>Login ke Portal PRIMADONA</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Login Form Area -->
    <div class="login-area ptb-100">
        <div class="container">
            <div class="login-form">
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login-portal-post') }}">
                    @csrf
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" placeholder="Masukkan email Anda" required>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                            placeholder="Masukkan password Anda" required>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">Ingat Saya</label>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 text-right">
                            <a href="{{ route('forgot-password') }}" class="forgot-password">Lupa Password?</a>
                        </div>
                    </div>

                    <button type="submit" class="default-btn">
                        Login
                    </button>

                    <div class="text-center mt-4">
                        <p>Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .login-area {
            background-color: #f8f9fa;
            min-height: calc(100vh - 200px);
            display: flex;
            align-items: center;
        }

        .login-form {
            max-width: 500px;
            margin: 0 auto;
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .login-form h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: 600;
            color: #555;
        }

        .default-btn {
            width: 100%;
            padding: 12px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            margin-top: 20px;
            transition: all 0.3s ease;
        }

        .default-btn:hover {
            background: #0056b3;
        }

        .forgot-password {
            color: #007bff;
            text-decoration: none;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .alert {
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 5px;
        }
    </style>
@endpush
