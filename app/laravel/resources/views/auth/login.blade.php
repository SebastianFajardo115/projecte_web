@extends('layout')

@section('content')
<div class="card auth-card">
    <div class="card-body">
        <h1>Login</h1>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus autocomplete="username">
                @error('email') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="password">Password</label>
                <input id="password" type="password" name="password" class="form-control" required autocomplete="current-password">
                @error('password') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3 d-flex gap-2 align-items-center">
                <input id="remember_me" type="checkbox" name="remember">
                <label for="remember_me">Remember me</label>
            </div>

            <div class="auth-links">
                @if (Route::has('password.request'))
                    <a class="btn btn-secondary btn-sm" href="{{ route('password.request') }}">Forgot password?</a>
                @endif
                <button class="btn btn-primary" type="submit">Log in</button>
            </div>
        </form>
    </div>
</div>
@endsection
