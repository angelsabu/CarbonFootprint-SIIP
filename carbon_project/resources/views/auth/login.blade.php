@extends('layout')

@section('content')

<div class="min-vh-100 d-flex align-items-center justify-content-center py-5 auth-bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">
                <div class="glass-card p-5">

                    <div class="text-center mb-4">
                        <div style="font-size: 2.5rem;" class="mb-2">🌿</div>
                        <h2 class="page-title mb-1" style="font-size: 1.6rem;">Welcome Back</h2>
                        <p style="color:#64748b; font-size:0.9rem;" class="mb-0">Sign in to your Carbon Footprint account</p>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" novalidate>
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">📧 Email Address</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="you@example.com" required autofocus autocomplete="username">
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">🔒 Password</label>
                            <input id="password" type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Enter your password" required autocomplete="current-password">
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember" style="color:#475569; font-size:0.9rem;">
                                Remember me
                            </label>
                        </div>

                        <button type="submit" class="btn btn-submit">Sign In</button>
                    </form>

                    <div class="text-center mt-4">
                        @if (Route::has('password.request'))
                            <p class="mb-3">
                                <a href="{{ route('password.request') }}" style="color:#10b981; text-decoration:none; font-size:0.9rem;">Forgot your password?</a>
                            </p>
                        @endif
                        <p class="mb-0" style="color:#64748b; font-size:0.9rem;">
                            Don't have an account?
                            <a href="{{ route('register') }}" style="color:#059669; text-decoration:none; font-weight:600;">Create one</a>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection