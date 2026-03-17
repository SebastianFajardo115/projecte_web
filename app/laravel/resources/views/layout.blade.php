<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BiblioJocs</title>
    <style>
        :root { --bg:#f7f7fb; --card:#fff; --text:#1f2937; --muted:#6b7280; --line:#e5e7eb; --primary:#2563eb; --danger:#dc2626; --ok:#16a34a; --warning:#d97706; }
        * { box-sizing:border-box; }
        body { margin:0; font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,sans-serif; background:var(--bg); color:var(--text); }
        .container { max-width:1100px; margin:0 auto; padding:1rem; }
        .navbar { background:#111827; color:#fff; margin-bottom:1rem; }
        .nav-wrap { display:flex; justify-content:space-between; align-items:center; gap:1rem; padding:.85rem 1rem; max-width:1100px; margin:0 auto; }
        .nav-left,.nav-right,.flex-row,.d-flex { display:flex; align-items:center; gap:.6rem; flex-wrap:wrap; }
        .navbar-brand,a { text-decoration:none; color:inherit; }
        .navbar-brand { color:#fff; font-weight:600; }
        .badge-role { font-size:.75rem; background:#374151; color:#fff; padding:.2rem .5rem; border-radius:999px; }
        .card { background:var(--card); border:1px solid var(--line); border-radius:.7rem; }
        .card-header { padding:.8rem 1rem; border-bottom:1px solid var(--line); }
        .card-body, .p-4 { padding:1rem; }
        .table { width:100%; border-collapse:collapse; background:var(--card); border:1px solid var(--line); border-radius:.7rem; overflow:hidden; margin-bottom:1rem; }
        .table th,.table td { padding:.65rem .75rem; border-bottom:1px solid var(--line); text-align:left; }
        .table tr:last-child td { border-bottom:0; }
        .btn { display:inline-block; border:0; padding:.5rem .8rem; border-radius:.55rem; color:#fff; background:#4b5563; cursor:pointer; font-size:.9rem; }
        .btn-primary { background:var(--primary); }
        .btn-success { background:var(--ok); }
        .btn-warning { background:var(--warning); }
        .btn-danger { background:var(--danger); }
        .btn-secondary { background:#4b5563; }
        .btn-info { background:#0891b2; }
        .btn-sm { padding:.35rem .6rem; font-size:.82rem; }
        .form-control,.form-select,input,select,textarea { width:100%; padding:.55rem .65rem; border:1px solid #cbd5e1; border-radius:.5rem; background:#fff; }
        .form-label { display:block; margin-bottom:.35rem; font-weight:600; }
        .mb-3 { margin-bottom:1rem; }
        .mb-4 { margin-bottom:1.25rem; }
        .row { display:flex; gap:1rem; flex-wrap:wrap; }
        .col-md-6 { flex:1 1 280px; }
        .justify-content-between { justify-content:space-between; }
        .align-items-center { align-items:center; }
        .flex-wrap { flex-wrap:wrap; }
        .gap-2 { gap:.5rem; }
        .alert { padding:.7rem .9rem; border-radius:.5rem; margin-bottom:1rem; border:1px solid; }
        .alert-success { background:#ecfdf5; border-color:#a7f3d0; color:#065f46; }
        .alert-info { background:#eff6ff; border-color:#bfdbfe; color:#1e3a8a; }
        .text-muted { color:var(--muted); }
        .text-danger { color:var(--danger); font-size:.85rem; }
        .auth-card { max-width:520px; margin:2rem auto; }
        .auth-links { display:flex; gap:.5rem; justify-content:flex-end; }
    </style>
</head>
<body>
<nav class="navbar">
    <div class="nav-wrap">
        <div class="nav-left">
            @auth
                <a class="navbar-brand" href="{{ route('videojocs.index') }}">BiblioJocs</a>
                @if(auth()->user()->isAdmin())
                    <a class="navbar-brand" href="{{ route('categorias.index') }}">Categories</a>
                    <a class="navbar-brand" href="{{ route('etiquetas.index') }}">Etiquetes</a>
                @endif
            @else
                <a class="navbar-brand" href="{{ route('welcome') }}">BiblioJocs</a>
            @endauth
        </div>
        <div class="nav-right">
            @auth
                <span>{{ auth()->user()->name }} · {{ auth()->user()->email }}</span>
                <span class="badge-role">{{ auth()->user()->role }}</span>
                <a class="btn btn-secondary btn-sm" href="{{ route('profile.edit') }}">Perfil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-danger btn-sm" type="submit">Logout</button>
                </form>
            @else
                <a class="btn btn-secondary btn-sm" href="{{ route('login') }}">Login</a>
                <a class="btn btn-primary btn-sm" href="{{ route('register') }}">Register</a>
            @endauth
        </div>
    </div>
</nav>
<div class="container">
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif
    @yield('content')
</div>
</body>
</html>
