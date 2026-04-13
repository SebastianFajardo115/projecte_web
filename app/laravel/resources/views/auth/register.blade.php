@extends('layout')

@section('content')
<div class="max-w-md mx-auto">
    <div class="card">
        <div class="card-body">
            <h1 class="text-2xl font-bold text-slate-900 mb-6">Crear compte</h1>
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-4">
                    <label class="form-label" for="name">Nom</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" class="form-input" required autofocus autocomplete="name">
                    @error('name') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label" for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-input" required autocomplete="username">
                    @error('email') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label" for="password">Contrasenya</label>
                    <input id="password" type="password" name="password" class="form-input" required autocomplete="new-password">
                    @error('password') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label" for="password_confirmation">Confirmar contrasenya</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-input" required autocomplete="new-password">
                    @error('password_confirmation') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="flex flex-col gap-4">
                    <button class="btn-primary w-full" type="submit">Crear compte</button>
                    <a class="btn-secondary text-center" href="{{ route('login') }}">Ja tens compte? Inicia sesió</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
