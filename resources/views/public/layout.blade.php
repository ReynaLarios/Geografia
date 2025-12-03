<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departamento de geografia y ordenación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --azul-suave: #dbeafe;
            --azul-medio: #60a5fa;
            --azul-oscuro: #1e3a8a;
            --gris-claro: #f5f6fa;
            --gris-medio: #000000ff;
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
            object-fit: contain;
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

        .search-container {
            width: 100%;
            max-width: 350px;
            margin: 0 auto;
            position: relative;
        }

        .search-wrapper {
            display: flex;
            align-items: center;
            background: white;
            border: 1px solid #60a5fa;
            border-radius: 25px;
            padding: 5px 10px;
            transition: 0.3s;
        }

        #searchInput {
            border: none;
            flex: 1;
            padding: 10px;
            border-radius: 20px;
            outline: none;
            font-size: 16px;
        }

        .search-btn {
            background: #60a5fa;
            border: none;
            color: white;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            font-size: 18px;
            cursor: pointer;
        }

        .results-box {
            position: absolute;
            top: 55px;
            left: 0;
            width: 100%;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            z-index: 99;
            display: none;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-top d-flex justify-content-between align-items-center">
    <a href="https://www.udg.mx/es" class="navbar-brand d-flex align-items-center" target="_blank">
        <img src="{{ asset('/logo.png') }}" alt="Logo">
    </a>
            <form action="{{ route('buscador.resultados') }}" method="get" class="d-flex">
                <input type="text" name="q" placeholder="Buscar..." class="form-control me-2" required>
                <button type="submit" class="btn btn-primary">🔍</button>
            </form>
      

    </nav>

    @php
        use App\Models\Banner;
        use App\Models\NavbarSeccion;

        $banner = Banner::latest()->first();
        $navbarSecciones = NavbarSeccion::with('contenidosNavbar')->where('oculto_publico', false)->get();
    @endphp

    <div class="banner-container position-relative">
        @if ($banner && $banner->imagen && file_exists(storage_path('app/public/banners/' . $banner->imagen)))
            <img src="{{ asset('storage/banners/' . $banner->imagen) }}" class="banner img-fluid" alt="Banner">
        @else
            <img src="{{ asset('Geo.jpg') }}" class="banner img-fluid" alt="Banner por defecto">
        @endif
    </div>
<nav class="navbar-bottom">

    <div class="paste-button">
        <button class="button" onclick="window.location='{{ route('public.inicio.index') }}'">
            Inicio
        </button>
    </div>

    @foreach ($navbarSecciones ?? [] as $sec)
        <div class="paste-button">
            <button class="button"
                onclick="window.location='{{ route('public.navbar.secciones.show', $sec->slug) }}'">
                {{ $sec->nombre }}
                @if(optional($sec->contenidosNavbar)->where('oculto_publico', false)->count())
                    ▼
                @endif
            </button>

            @if(optional($sec->contenidosNavbar)->where('oculto_publico', false)->count())
                <div class="dropdown-content">
                    @foreach ($sec->contenidosNavbar->where('oculto_publico', false) ?? [] as $contenido)
                        <a href="{{ route('public.navbar.contenido.show', $contenido->slug) }}">
                            {{ $contenido->titulo }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    @endforeach

</nav>

<div class="layout">
 <aside class="sidebar">

     <div class="contenido-fixed">
            <button class="fancy" onclick="window.location='{{ route('public.personas.index') }}'">
              Académicos
            </button>
        </div>
        
      <div class="videoteca-fixed">
            <button class="fancy" onclick="window.location='{{ route('videoteca') }}'">
                Videoteca
            </button>
        </div>

        
        <hr style="border: 0; height: 2px; background: #90caf9; margin: 15px 0; border-radius: 4px;">

    @if(isset($seccion) && optional($seccion->contenidos)->count())
        <ul class="nav flex-column">
            @foreach(($seccion->contenidos ?? [])->where('oculto_publico', 0) as $contenidoItem)
    <li class="mb-2">
        <a href="{{ route('public.contenidos.show', $contenidoItem->slug) }}" class="fancy
            {{ (isset($contenido) && $contenido->id === $contenidoItem->id) ? 'active' : '' }}">
            {{ $contenidoItem->titulo }}
        </a>
    </li>
@endforeach

       
        </ul>
      <div class="contenido-fixed mt-3">
        <button class="fancy w-100" onclick="window.history.back()">
            ← Regresar
        </button>
    </div>
  
    @elseif(isset($secciones) && optional($secciones)->count())
        <ul class="nav flex-column">
            @foreach($secciones ?? [] as $sec)
                @if(!$sec->oculto_publico)
                    <li class="mb-2">
                        <a href="{{ route('public.secciones.show', $sec->slug) }}" class="fancy">
                            {{ $sec->nombre }}
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    @endif


</aside>

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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const searchBox = document.getElementById('searchBox');
            const searchUrl = "{{ route('buscador.autocomplete') }}";

            let searchResults = document.getElementById('searchResults');
            if (!searchResults) {
                searchResults = document.createElement('div');
                searchResults.id = 'searchResults';
                searchResults.style.position = 'absolute';
                searchResults.style.background = '#fff';
                searchResults.style.border = '1px solid #ccc';
                searchResults.style.zIndex = '1000';
                searchResults.style.width = searchInput.offsetWidth + 'px';
                searchResults.style.maxHeight = '300px';
                searchResults.style.overflowY = 'auto';
                searchResults.style.display = 'none';
                searchBox.appendChild(searchResults);
            }

            searchInput.addEventListener('input', function() {
                const q = this.value.trim().toLowerCase();


                if (q.length < 2) {
                    searchResults.style.display = 'none';
                    return;
                }

                fetch(searchUrl + '?q=' + encodeURIComponent(q))
                    .then(res => res.json())
                    .then(data => {
                        searchResults.innerHTML = '';

                        if (!data.length) {
                            searchResults.innerHTML =
                                '<div class="p-2 text-muted text-center">Sin resultados</div>';
                        } else {
                            let hasResults = false;

                            data.forEach(item => {

                                if (item.nombre.toLowerCase().startsWith(q)) {
                                    const link = document.createElement('a');
                                    link.href = item.url || '#';
                                    link.textContent = item.nombre;
                                    link.className =
                                        'd-block p-2 text-decoration-none text-primary';
                                    searchResults.appendChild(link);
                                    hasResults = true;
                                }
                            });

                            if (!hasResults) {
                                searchResults.innerHTML =
                                    '<div class="p-2 text-muted text-center">Sin resultados</div>';
                            }
                        }

                        searchResults.style.display = 'block';
                    })
                    .catch(err => console.error(err));
            });

            document.addEventListener('click', function(e) {
                if (!searchBox.contains(e.target)) {
                    searchResults.style.display = 'none';
                }
            });

            window.addEventListener('resize', () => {
                searchResults.style.width = searchInput.offsetWidth + 'px';
            });
        });
    </script>

</body>

</html>
