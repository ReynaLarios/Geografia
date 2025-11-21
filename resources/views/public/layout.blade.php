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
            padding: 10px 20px;
            font-weight: 500;
            text-transform: uppercase;
            cursor: pointer;
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
            border-radius: 20px;
            color: var(--azul-oscuro);
            font-weight: 500;
            text-transform: uppercase;
            padding: 8px 12px;
            margin: 6px 0;
            width: 100%;
            text-align: center;
            text-decoration: none;
            display: block;
        }
        .fancy:hover {
            background-color: var(--azul-medio);
            color: var(--blanco);
        }

        .content {
            flex: 1;
            padding: 20px;
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
<div class="mb-3">
    <input type="text" id="buscador" placeholder="Buscar..." style="padding:5px 10px; width:300px; border-radius:25px; border:1px solid #60a5fa;">
</div>

<ul id="resultados"></ul>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    $('#buscador').on('keyup', function(){
        let query = $(this).val();
        $.ajax({
            url: "{{ route('public.buscar') }}",
            type: "GET",
            data: { query: query },
            success: function(data){
                $('#resultados').html(data.html);
            }
        });
    });
});
</script>


@php
    use App\Models\Banner;
    use App\Models\NavbarSeccion;

    $banner = Banner::latest()->first();
    $navbarSecciones = NavbarSeccion::with('contenidosNavbar')
                            ->where('oculto_publico', false)
                            ->get();
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
                @if($sec->contenidosNavbar->where('oculto_publico', false)->count()) ▼ @endif
            </button>

            @if($sec->contenidosNavbar->where('oculto_publico', false)->count())
                <div class="dropdown-content">
                    @foreach($sec->contenidosNavbar->where('oculto_publico', false) as $contenido)
                        <a href="{{ route('public.navbar.contenido.show', $contenido->id) }}">
                            {{ $contenido->titulo }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    @endforeach
</nav>

{{-- LAYOUT PRINCIPAL --}}
<div class="layout">
    {{-- SIDEBAR --}}
<aside class="sidebar">

  
    {{-- LISTA DE SECCIONES --}}
    <ul class="list-unstyled">
        @if(!empty($secciones))
            @foreach($secciones as $sec)
                @if(!$sec->oculto_publico)
                    <li class="mb-2">
                        <a href="{{ route('public.secciones.show', $sec->id) }}" class="fancy">
                            {{ $sec->nombre }}
                        </a>
                    </li>
                @endif
            @endforeach
        @else
            <li>No hay secciones disponibles</li>
        @endif

          {{-- BOTÓN VIDEOTECA --}}
    <div class="mb-3">
        <a href="{{ route('videoteca') }}" class="fancy d-block text-center py-2">
            Videoteca
        </a>
    </div>
    </ul>

</aside>



    {{-- CONTENIDO --}}
    <main class="content">
        @yield('contenido')
    </main>
</div>

<footer>
    <p class="fw-bold">CENTRO UNIVERSITARIO DE CIENCIAS SOCIALES Y HUMANIDADES</p>
    <p>Los Belenes. Av. José Parres Arias #150, Zapopan, Jalisco, México.</p>
    <p>© 1997 - 2025 Universidad de Guadalajara</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')

</body>
</html>
