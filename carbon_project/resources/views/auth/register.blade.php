@extends('layout')

@section('content')

<div class="min-vh-100 d-flex align-items-center justify-content-center py-5 auth-bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="glass-card p-5">

                    <div class="text-center mb-4">
                        <div style="font-size: 2.5rem;" class="mb-2">✨</div>
                        <h2 class="page-title mb-1" style="font-size: 1.6rem;">Create Account</h2>
                        <p style="color:#64748b; font-size:0.9rem;" class="mb-0">Start tracking your daily carbon footprint</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" novalidate>
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">👤 Full Name</label>
                            <input id="name" name="name" type="text" value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Your full name" required autofocus>
                            @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">📧 Email Address</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="you@example.com" required>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">🔒 Password</label>
                            <input id="password" name="password" type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Create a password" required>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">🔒 Confirm Password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                placeholder="Repeat password" required>
                            @error('password_confirmation')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-submit">Register</button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="mb-0" style="color:#64748b; font-size:0.9rem;">
                            Already have an account?
                            <a href="{{ route('login') }}" style="color:#059669; text-decoration:none; font-weight:600;">Login</a>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection