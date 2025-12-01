@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center"
    style=" background: #FFFF; padding: 20px;">

    <div class="d-flex flex-column flex-md-row shadow-lg mx-auto"
        style="width: 100%; max-width: 900px; background: #fff; border-radius: 18px; overflow: hidden;">

        {{-- LEFT SIDE --}}
        <div class="d-flex flex-column justify-content-center text-white p-5 text-center text-md-start"
            style="width: 100%; max-width: 45%;
                   background: linear-gradient(135deg, #4e7eff, #6aa4ff);">

            <h2 class="fw-bold" style="font-size: 2rem;">Kasir Digital</h2>

            <p class="mt-2" style="font-size: .95rem;">
                Rasakan pengalaman yang baru dengan menggunakan Kasir Digital
            </p>

            <p class="mt-auto pt-4" style="font-size: .8rem; opacity: .8;">
                © 2025 Kasir Digital
            </p>
        </div>

        {{-- RIGHT SIDE (FORM) --}}
        <div class="p-5 d-flex flex-column justify-content-center w-100" style="max-width: 55%;">

            <div class="text-center mb-4">
                <h3 class="fw-bold mb-1">Welcome Back</h3>
                <p class="text-muted" style="font-size: .9rem;">
                    Silakan login untuk melanjutkan
                </p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <input id="email" type="email"
                        class="form-control rounded-3 @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autofocus
                        placeholder="Enter your email">

                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <input id="password" type="password"
                        class="form-control rounded-3 @error('password') is-invalid @enderror"
                        name="password" required placeholder="Enter your password">

                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Login Button --}}
                <button type="submit"
                    class="btn btn-primary w-100 py-2 rounded-3 fw-semibold"
                    style="font-size: .95rem;">
                    Login
                </button>

                {{-- Forgot Password --}}
                @if (Route::has('password.request'))
                <div class="text-center mt-3">
                    <a href="{{ route('password.request') }}"
                        class="text-decoration-none" style="font-size: .85rem;">
                        Forgot password?
                    </a>
                </div>
                @endif
            </form>

        </div>
    </div>

</div>
@endsection
