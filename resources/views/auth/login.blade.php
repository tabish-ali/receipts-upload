@extends('layouts.app')

@section('content')
<div class="padding-auth h-100 auth-bg bgi-size-cover bgi-position-top bgi-no-repeat">
    <div class="mt-4 d-flex justify-content-center flex-column align-items-center px-6">
        <div class="px-4 py-8 d-flex justify-content-center flex-column text-center align-items-center">
            <h2 class="fw-bold">Login</h2>
        </div>
        <form class="border border-warning border-2 rounded" method="POST" action="{{ route('login') }}" class="auth-form d-flex flex-column" style="width: 400px">
            @csrf
            <div class="d-flex flex-column py-4 w-100">
                <div class="form-group px-4 py-1">

                    <input id="login" type="text" class="form-control px-8 @error('login') is-invalid @enderror" name="login" value="{{ old('login') }}" required autocomplete="login" autofocus placeholder="Username or Email">
                    @error('login')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group mt-2 px-4 py-1">

                    <input id="password" type="password" class="form-control px-8 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="mt-4 px-4 py-1 d-flex justify-content-between">
                    <button type="submit" class="btn btn-success">
                        <svg class="hero-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                        </svg>

                        Sign In
                    </button>
                    @if (Route::has('password.request'))
                    <!-- <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a> -->
                    @endif
                </div>
        </form>
    </div>
</div>
@endsection