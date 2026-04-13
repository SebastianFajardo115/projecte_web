@extends('layout')

@section('content')
<div class="max-w-md mx-auto">
    <div class="card">
        <div class="card-body">
            <h1 class="text-2xl font-bold text-slate-900 mb-6">Iniciar sesió</h1>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label class="form-label" for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-input" required autofocus autocomplete="username">
                    @error('email') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label" for="password">Contrasenya</label>
                    <input id="password" type="password" name="password" class="form-input" required autocomplete="current-password">
                    @error('password') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4 flex items-center">
                    <input id="remember_me" type="checkbox" name="remember" class="rounded border-slate-300">
                    <label for="remember_me" class="ml-2 text-slate-700">Recorda'm</label>
                </div>

                <div class="flex flex-col gap-4">
                    @if (Route::has('password.request'))
                        <a class="btn-secondary text-center" href="{{ route('password.request') }}">He oblidat la contrasenya</a>
                    @endif
                    <button class="btn-primary w-full" type="submit">Iniciar sesió</button>
                </div>

                <div class="mt-6 text-center">
                    <p class="text-slate-600">No tens compte? <a href="{{ route('register') }}" class="text-primary-600 hover:text-primary-700 font-semibold">Registra't aquí</a></p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
