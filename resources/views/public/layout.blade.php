<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Licenciatura en Geografía</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --azul-suave: #dbeafe;
            --azul-medio: #60a5fa;
            --azul-oscuro: #1e3a8a;
            --gris-claro: #f5f6fa;
            --gris-medio: #d1d5db;
            --blanco: #ffffff;
            --sombra: rgba(0, 0, 0, 0.05);
        }

        body {
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--gris-claro);
            color: #1e293b;
        }

        .navbar-top {
            background-color: var(--blanco);
            box-shadow: 0 2px 4px var(--sombra);
            padding: 0.5rem 1rem;
        }
        .navbar-top img { max-height: 90px; }

        .banner { width: 100%; height: 350px; object-fit: cover; display: block; }

        .navbar-bottom {
            background-color: var(--azul-oscuro);
            padding: 1rem;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
        }
        .navbar-bottom .paste-button { position: relative; display: inline-block; }
        .navbar-bottom .button {
            background-color: var(--azul-oscuro);
            color: var(--blanco);
            border: none;
            border-radius: 25px;
            padding: 12px 25px;
            font-weight: 500;
            text-transform: uppercase;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        }
        .navbar-bottom .button:hover { background-color: var(--azul-suave); color: var(--azul-oscuro); }

        .dropdown-content {
            display: none;
            position: absolute;
            z-index: 10;
            min-width: 200px;
            background-color: var(--azul-medio);
            border-radius: 10px;
            top: 45px;
            left: 50%;
            transform: translateX(-50%);
        }
        .dropdown-content a {
            color: var(--blanco);
            padding: 10px 15px;
            display: block;
            text-decoration: none;
        }
        .paste-button:hover .dropdown-content { display: block; }

        .layout {
            display: flex;
            flex: 1;
            background: var(--blanco);
        }

        .sidebar {
            width: 260px;
            background-color: var(--blanco);
            border-right: 1px solid var(--gris-medio);
            padding: 20px;
        }
        .sidebar h4 {
            color: var(--azul-oscuro);
            font-weight: 600;
            margin-bottom: 1rem;
            border-bottom: 2px solid var(--azul-medio);
            padding-bottom: 5px;
        }
        .fancy {
            background-color: var(--azul-suave);
            border: none;
            border-radius: 25px;
            color: var(--azul-oscuro);
            font-weight: 500;
            text-transform: uppercase;
            padding: 10px 15px;
            margin: 8px 0;
            width: 100%;
            text-align: center;
            text-decoration: none;
            display: block;
            transition: background 0.3s, transform 0.2s;
        }
        .fancy:hover {
            background-color: var(--azul-medio);
            color: var(--blanco);
            transform: translateY(-2px);
        }

        .content {
            flex: 1;
            padding: 30px;
            background: var(--gris-claro);
        }

        footer {
            position: relative;
            background: linear-gradient(135deg, #60a5fa, #1e3a8a);
            color: white;
            padding: 40px 10px 20px 10px;
            text-align: center;
            overflow:hidden;
        }
        .wave {
            position: absolute;
            top: -30px;
            left: 0;
            width:100%;
            overflow:hidden;
            line-height:0;
        }
        .wave svg { width: 100%; height: 80px; }

        @media (max-width:768px){
            .layout{ flex-direction: column; }
            .sidebar{ width:100%; border-right:none; border-bottom:1px solid var(--gris-medio); }
            .navbar-bottom{ flex-direction: column; gap:8px; }
        }
    </style>
</head>
<body>

{{-- NAVBAR SUPERIOR --}}
<nav class="navbar navbar-top d-flex justify-content-between align-items-center">
    <a href="{{ route('public.inicio.index') }}" class="navbar-brand d-flex align-items-center">
        <img src="{{ asset('/logo.png') }}" alt="Logo">
    </a>
</nav>

@php
    use App\Models\Banner;
    use App\Models\NavbarSeccion;
    $banner = Banner::latest()->first();
    $navbarSecciones = NavbarSeccion::with('contenidosNavbar')->get();
@endphp

{{-- BANNER --}}
<div class="banner-container position-relative">
    @if($banner && $banner->imagen && file_exists(storage_path('app/public/banners/' . $banner->imagen)))
        <img src="{{ asset('storage/banners/' . $banner->imagen) }}" class="banner img-fluid" alt="Banner">
    @else
        <img src="{{ asset('images/banner-default.jpg') }}" class="banner img-fluid" alt="Banner por defecto">
    @endif
</div>

{{-- NAVBAR INFERIOR --}}
<nav class="navbar-bottom">
    @foreach($navbarSecciones as $sec)
        <div class="paste-button">
            <button class="button" onclick="window.location='{{ route('public.navbar.secciones.show', $sec->id) }}'">
                {{ $sec->nombre }}
                @if($sec->contenidosNavbar->count()) ▼ @endif
            </button>

            @if($sec->contenidosNavbar->count())
                <div class="dropdown-content">
                    @foreach($sec->contenidosNavbar as $contenido)
                        <a href="{{ route('public.navbar.contenidos.show', $contenido->id) }}">{{ $contenido->titulo }}</a>
                    @endforeach
                </div>
            @endif
        </div>
    @endforeach
</nav>

<div class="layout">
    {{-- SIDEBAR --}}
    <aside class="sidebar">
        <ul class="nav flex-column">
            @foreach($secciones ?? [] as $sec)
                <li class="mb-2">
                    <a href="{{ route('public.secciones.show', $sec->id) }}" class="fancy">
                        {{ $sec->nombre }}
                        
                    </a>
                </li>
            @endforeach
        </ul>
    </aside>

    {{-- CONTENIDO --}}
    <main class="content">
        @yield('contenido')
    </main>
</div>

<footer>
    <div class="wave">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28..." fill="#ffffff" opacity="0.25"></path>
        </svg>
    </div>

    <p class="fw-bold">CENTRO UNIVERSITARIO DE CIENCIAS SOCIALES Y HUMANIDADES</p>
    <p>Los Belenes. Av. José Parres Arias #150, Zapopan, Jalisco, México.</p>
    <p>© 1997 - 2025 Universidad de Guadalajara</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@yield('scripts')

</body>
</html>
