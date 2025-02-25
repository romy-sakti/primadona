@extends('frontend.layout.app')

@section('title', 'Login Portal PRIMADONA')

@section('content')
<!-- Page banner Area -->
<div class="page-banner bg-1">
    <div class="d-table">
        <div class="d-table-cell">
            <div class="container">
                <div class="page-content">
                    <h2>Login Portal PRIMADONA</h2>
                    <ul>
                        <li>PELAYANAN INFORMASI PERMOHONAN PENGADILAN BERBASIS DIGITAL <br> PENGADILAN NEGERI TANJUNG
                            JABUNG
                            TIMUR</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Page banner Area -->

<!-- Start Sign in Area -->
<div class="sign-in-area ptb-100">
    <div class="container">
        <div class="section-title">
            <h2>Masuk ke Portal PRIMADONA</h2>
            <p>Silahkan masukkan email dan password Anda untuk mengakses portal PRIMADONA.</p>
        </div>

        <div class="sign-in-form">
            <form method="POST" action="{{ route('login-portal-post') }}">
                @csrf
                <div class="form-group">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        id="email" placeholder="Email" value="{{ old('email') }}" required>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                        id="password" placeholder="Password" required>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group form-check text-center">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="remember" {{
                        old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="exampleCheck1">Ingat Saya</label>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn default-btn-one">Sign In</button>

                    {{-- <p class="account-decs">
                        Not a member? <a href="sign-up.html">Sign Up</a>
                    </p> --}}
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Sign in  Area -->

<script>
    @if(session('success'))
        Swal.fire({
            title: 'Success!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'Okay'
        });
    @endif

    @if(session('error'))
        Swal.fire({
            title: 'Error!',
            text: "{{ session('error') }}",
            icon: 'error',
            confirmButtonText: 'Okay'
        });
    @endif
</script>

@endsection
