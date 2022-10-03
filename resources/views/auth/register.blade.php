@extends('layouts.app')

@section('content')
<div class="padding-auth h-100 auth-bg bgi-size-cover bgi-position-top bgi-no-repeat">
    <div class="mt-4 d-flex justify-content-center flex-column align-items-center px-6">
        <div class="px-4 py-6 d-flex justify-content-center flex-column text-center">
            <h1 class="fw-bold">Register</h1>
        </div>
        <form class="mt-4 border border-warning border-2 rounded auth-form d-flex flex-column" method="POST" action="{{ route('register') }}" style="width: 400px">
            @csrf
            <div class="d-flex flex-column py-4 w-100">

                <div class="form-group px-4 py-2">

                    <input placeholder="Enter username (Max-10-characters)" id="username" type="text" class="form-control px-8 @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                    @error('login')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group px-4 py-2">
                    <input placeholder="Enter your valid email" id="email" type="text" class="form-control px-8 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group px-4 py-2">
                    <input placeholder="Enter secret to become admin" id="secret" type="text" class="form-control px-8 @error('secret') is-invalid @enderror" name="secret" value="{{ old('secret') }}" required autocomplete="secret" autofocus>
                    @error('secret')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group px-4 py-2">

                    <input placeholder="Enter password greater than 8 characters" id="password" type="password" class="form-control px-8 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group px-4 py-2">

                    <input placeholder="Confirm your password" id="password-confirm" type="password" class="form-control px-8 @error('pass') is-invalid @enderror" name="password_confirmation" required autocomplete="current-password">
                </div>
                <div class="mt-4 px-4 py-1 d-flex flex-sm-row flex-column align-items-center justify-content-between">
                    <button type="submit" class="btn btn-success">
                        <svg class="hero-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                        </svg>

                         Register</button>
                    <div class="checkbox-inline mt-sm-0 mt-4">
                        <label class="checkbox m-0 text-muted">
                            <input type="checkbox" name="remember">
                            <span></span>I agree with terms and conditions </label>
                    </div>
                </div>
        </form>
    </div>
</div>
@endsection