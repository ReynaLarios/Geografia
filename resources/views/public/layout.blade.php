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

        .navbar-top img {
            max-height: 90px;
        }

        .banner {
            width: 100%;
            height: 350px;
            object-fit: cover;
            display: block;
        }

        .navbar-bottom {
            background-color: var(--azul-oscuro);
            padding: 1rem;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
        }

        .navbar-bottom .paste-button {
            position: relative;
            display: inline-block;
        }

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

        .navbar-bottom .button:hover {
            background-color: var(--azul-suave);
            color: var(--azul-oscuro);
        }

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

        .paste-button:hover .dropdown-content {
            display: block;
        }

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
            overflow: hidden;
        }

        @media (max-width:768px) {
            .layout {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid var(--gris-medio);
            }

            .navbar-bottom {
                flex-direction: column;
                gap: 8px;
            }
        }
        .navbar-bottom .dropdown-content {
    position: absolute;
    z-index: 9999; /* el dropdown queda arriba de todo */
}

.navbar-bottom .paste-button {
    position: relative; /* necesario para que el submenu se posicione bien */
}

    </style>
</head>

<body>

    
{{-- NAVBAR SUPERIOR --}}
<nav class="navbar navbar-top d-flex justify-content-between align-items-center">
    <a href="{{ route('public.inicio.index') }}" class="navbar-brand d-flex align-items-center">
        <img src="{{ asset('/logo.png') }}" alt="Logo">
    </a>
<?php

<style>
    #searchBox {
        position: relative;
        width: 300px;
        margin: 0 auto;
    }
    #searchResults {
        position: absolute;
        top: 40px;
        left: 0;
        width: 100%;
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        z-index: 999;
        display: none;
    }
    #searchResults a {
        display: block;
        padding: 10px;
        border-bottom: 1px solid #eee;
        text-decoration: none;
        color: #333;
    }
    #searchResults a:hover {
        background: #f0f8ff;
    }
</style>

<div id="searchBox" class="mt-3">
    <input type="text" id="searchInput" placeholder="Buscar..."
           style="width:100%; padding:10px 15px; border-radius:20px; border:1px solid #60a5fa;">
    <div id="searchResults"></div>
</div>

<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
    let q = this.value.trim();

    if (q.length < 2) {
        document.getElementById('searchResults').style.display = 'none';
        return;
    }

    fetch(`/buscador?search=${q}`)
        .then(r => r.json())
        .then(data => {
            let box = document.getElementById('searchResults');
            box.innerHTML = '';

            if (data.length === 0) {
                box.innerHTML = `<div class="p-2 text-center text-gray-500">Sin resultados</div>`;
            } else {
                data.forEach(item => {
                    box.innerHTML += `
                        <a href="${item.url}">
                            <strong>${item.nombre}</strong><br>
                            <small>${item.tipo}</small>
                        </a>
                    `;
                });
            }

            box.style.display = 'block';
        });
});
</script>


        </li>
    </ul>
</nav>



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
       <img src="{{ asset('Geo.jpg') }}" class="banner img-fluid" alt="Banner por defecto">
    @endif
</div>


    {{-- NAVBAR SUPERIOR --}}
    {{-- NAVBAR INFERIOR --}}
<nav class="navbar-bottom">

    <!-- Botón de Inicio -->
    <div class="paste-button">
        <button class="button" onclick="window.location='{{ route('public.inicio.index') }}'">
            Inicio
        </button>
    </div>


    <!-- SECCIONES DEL NAVBAR -->
    @foreach ($navbarSecciones as $sec)
        <div class="paste-button">
            <button class="button"
                onclick="window.location='{{ route('public.navbar.secciones.show', $sec->id) }}'">
                {{ $sec->nombre }}
                @if ($sec->contenidosNavbar->where('oculto_publico', false)->count())
                    ▼
                @endif
            </button>

            {{-- Dropdown interno --}}
            @if ($sec->contenidosNavbar->where('oculto_publico', false)->count())
                <div class="dropdown-content">
                    @foreach ($sec->contenidosNavbar->where('oculto_publico', false) as $contenido)
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
                @if (!empty($secciones))
                    @foreach ($secciones as $sec)
                        @if (!$sec->oculto_publico)
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

                
         <div class="contenido-fixed">
            <button class="fancy" onclick="window.location='{{ route('public.personas.index') }}'">
              Académicos
            </button>
        </div>
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
