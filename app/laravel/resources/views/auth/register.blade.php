@extends('layout')

@section('content')
<div class="card auth-card">
    <div class="card-body">
        <h1>Register</h1>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label" for="name">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" class="form-control" required autofocus autocomplete="name">
                @error('name') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control" required autocomplete="username">
                @error('email') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="password">Password</label>
                <input id="password" type="password" name="password" class="form-control" required autocomplete="new-password">
                @error('password') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="password_confirmation">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required autocomplete="new-password">
                @error('password_confirmation') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="auth-links">
                <a class="btn btn-secondary btn-sm" href="{{ route('login') }}">Already registered?</a>
                <button class="btn btn-primary" type="submit">Register</button>
            </div>
        </form>
    </div>
</div>
@endsection
