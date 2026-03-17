@extends("layout")

@section("content")
    <div class="card auth-card mx-auto" style="max-width: 760px;">
        <div class="card-body text-center p-5">
            <h1 class="h3 mb-3">Bienvenido a BiblioJocs</h1>
            <p class="text-muted mb-4">Inicia sesión para gestionar tu colección de videojuegos.</p>

            <div class="d-flex justify-content-center gap-2">
                <a href="{{ route("login") }}" class="btn btn-primary">Iniciar sesión</a>
                <a href="{{ route("register") }}" class="btn btn-outline-secondary">Registrarse</a>
            </div>
        </div>
    </div>
@endsection
