@extends('layouts.app')

@section('content')
<div style="background: #FFFF;"
    class="d-flex justify-content-center align-items-center">

    <div class="card shadow-lg border-0"
        style="width: 850px; border-radius: 16px; overflow: hidden;">

        <div class="row g-0">

            <!-- Left Section - Gradient / Accent -->
            <div class="col-md-5 d-flex flex-column justify-content-center text-white p-4"
                style="background: linear-gradient(135deg, #4e73df, #6f9eff);">

                <h2 class="fw-bold mb-2" style="font-size: 2rem;">Kasir Digital</h2>
                <p style="opacity: .9;">
                    Rasakan pengalaman yang baru dengan menggunakan Kasir Digital.
                </p>

                <div class="mt-auto">
                    <p class="small" style="opacity: .7;">
                        © {{ date('Y') }} Kasir Digital
                    </p>
                </div>
            </div>

            <!-- Right Section - Form -->
            <div class="col-md-7 p-5 bg-white">

                <h3 class="fw-bold mb-4">Create Your Account</h3>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Name</label>
                        <input id="name" type="text"
                            class="form-control rounded-3 @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name') }}" required autofocus
                            placeholder="Your name">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email Address</label>
                        <input id="email" type="email"
                            class="form-control rounded-3 @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required
                            placeholder="example@mail.com">
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <input id="password" type="password"
                            class="form-control rounded-3 @error('password') is-invalid @enderror"
                            name="password" required placeholder="Create password">
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm -->
                    <div class="mb-4">
                        <label for="password-confirm" class="form-label fw-semibold">
                            Confirm Password
                        </label>
                        <input id="password-confirm" type="password"
                            class="form-control rounded-3"
                            name="password_confirmation" required
                            placeholder="Repeat password">
                    </div>

                    <!-- Button -->
                    <button type="submit"
                        class="btn btn-primary w-100 py-2 rounded-3 fw-semibold mb-3">
                        Register
                    </button>

                    <div class="text-center">
                        <span class="text-muted">Already have an account?</span>
                        <a href="{{ route('login') }}"
                            class="fw-semibold text-decoration-none ms-1">
                            Login
                        </a>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>
@endsection
