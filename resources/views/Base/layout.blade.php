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
        .navbar-top .button {
            background: var(--azul-medio);
            color: var(--blanco);
            border: none;
            border-radius: 25px;
            padding: 8px 20px;
            font-weight: 600;
        }
        .navbar-top .button:hover { background: var(--azul-oscuro); transform: scale(1.05); }

 
        .banner { width: 100%; height: 350px; object-fit: cover; display: block; }

     
        .navbar-bottom {
            background-color: var(--azul-oscuro);
            padding: 1rem;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
        }
        .navbar-bottom .paste-button { position: relative; display: inline-block; margin: 0px; }
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

    .fancy.btn-borrar {
      background-color: #fee2e2;
      color: #b91c1c;
    }

    .fancy.btn-borrar:hover {
      background-color: #ef4444;
      color: var(--blanco);
    }

    .content {
      flex: 1;
      padding: 30px;
      background: var(--gris-claro);
    }


        footer { position: relative; background: linear-gradient(135deg, #60a5fa, #1e3a8a); color: white; padding: 40px 10px 20px 10px; text-align: center; overflow:hidden; }
        .wave { position: absolute; top: -30px; left: 0; width:100%; overflow:hidden; line-height:0; }
        .wave svg { width: 100%; height: 80px; }
        footer p { margin:5px 0; }

        @media (max-width:768px){
            .layout{ flex-direction: column; }
            .sidebar{ width:100%; border-right:none; border-bottom:1px solid var(--gris-medio);}
            .navbar-bottom{ flex-direction: column; gap:8px;}
        }
    </style>
</head>
</head>
<body>

<nav class="navbar navbar-top d-flex justify-content-between align-items-center" style="padding:0.25rem 1rem; height:70px;">
    <a href="https://www.udg.mx/es" class="navbar-brand d-flex align-items-center">
        <img src="{{ asset('/logo.png') }}" alt="Logo" style="height:70px;">
    </a>

  
    <div class="d-flex gap-3 align-items-center">
        <div class="input-container" style="background: #f5f6fa; border-radius:25px; padding:3px 10px; border:1px solid #60a5fa;">
            <input type="text" placeholder="Buscar..." style="border:none; outline:none; background:transparent; padding:5px 10px;">
            <svg width="18" height="18" fill="none" stroke="#1e293b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="button" style="padding:6px 15px; font-size:0.9rem;">Cerrar sesión</button>
        </form>
    </div>
</nav>

@php 
    $banner = \App\Models\Banner::latest()->first(); 
@endphp

<div class="banner-container position-relative">
    @if ($banner && file_exists(storage_path('app/public/' . $banner->imagen)))
        <img src="{{ asset('storage/'.$banner->imagen) }}" class="banner" alt="Banner">
    @endif

    <div class="position-absolute top-0 end-0 m-2 d-flex gap-2">
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editarBannerModal">
            ✎ Editar
        </button>
        @if($banner)
            
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger">🗑</button>
            </form>
        @endif
    </div>
</div>
<div class="modal fade" id="editarBannerModal" tabindex="-1" aria-labelledby="editarBannerLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('banner.actualizar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="editarBannerLabel">Editar Banner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="imagen" class="form-label">Subir nueva imagen</label>
                        <input type="file" class="form-control" name="imagen" required>
                    </div>
                    @if ($banner)
                        <p>Imagen actual:</p>
                        <img src="{{ asset('storage/' . $banner->imagen) }}" class="img-fluid" alt="Banner actual">
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Actualizar Banner</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<nav class="navbar-bottom">
    <div class="paste-button">
        <button class="button" onclick="window.location='{{ route('navbar.secciones.crear') }}'">
            + Agregar Sección Navbar
        </button>
    </div>
    @foreach($navbarSecciones ?? [] as $sec)
        <div class="paste-button">
            <button class="button">
                {{ $sec->nombre }} @if($sec->hijos->count()) ▼ @endif
            </button>
            <div class="dropdown-content">
                <a href="{{ route('contenidos.crear') }}?seccion_id={{ $sec->id }}">
                    + Agregar Submenú / Contenido
                </a>
                @foreach($sec->hijos as $hijo)
                    <a href="{{ $hijo->ruta ?? '#' }}">
                        {{ $hijo->nombre }}
                    </a>
                @endforeach
            </div>
        </div>
    @endforeach
</nav>

  <div class="layout">
    <aside class="sidebar">
      @isset($seccion)
      <h4>{{ $seccion->nombre }}</h4>
      <button class="fancy mb-3"
        onclick="window.location='{{ route('contenidos.crear') }}?seccion_id={{ $seccion->id }}'">
        + Agregar Contenido
      </button>
      <ul class="nav flex-column">
        @foreach ($seccion->contenidos as $contenidoItem)
        <li class="mb-2 d-flex justify-content-between align-items-center">
          <a href="{{ route('contenidos.mostrar', $contenidoItem->id) }}" class="fancy flex-grow-1">
            {{ $contenidoItem->titulo }}
          </a>
          <div class="d-flex gap-1">
            <a href="{{ route('contenidos.editar', $contenidoItem->id) }}" class="fancy">✎</a>
            <form action="{{ route('contenidos.borrar', $contenidoItem->id) }}" method="POST"
              onsubmit="return confirm('¿Seguro que quieres borrar este contenido?')">
              @csrf
              @method('DELETE')
              <button class="fancy btn-borrar" type="submit">🗑</button>
            </form>
          </div>
        </li>
        @endforeach
      </ul>
      @else
      <h4>Secciones</h4>
      <button class="fancy mb-3" onclick="window.location='{{ route('secciones.crear') }}'">+ Agregar Sección</button>
      <ul class="nav flex-column">
        @foreach ($secciones ?? [] as $sec)
        <li class="mb-2 d-flex justify-content-between align-items-center">
          <a href="{{ route('secciones.mostrar', $sec->id) }}" class="fancy flex-grow-1">{{ $sec->nombre }}</a>
          <div class="d-flex gap-1">
            <a href="{{ route('secciones.editar', $sec->id) }}" class="fancy">✎</a>
            <form action="{{ route('secciones.borrar', $sec->id) }}" method="POST"
              onsubmit="return confirm('¿Seguro que quieres borrar esta sección?')">
              @csrf
              @method('DELETE')
              <button class="fancy btn-borrar" type="submit">🗑</button>
            </form>
          </div>
        </li>
        @endforeach
      </ul>
      @endisset
    </aside>

    <main class="content">
      @yield('contenido')
    </main>
  </div>
    <footer>
        <div class="wave">
            <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" fill="#ffffff" opacity="0.25"></path>
                <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" fill="#ffffff" opacity="0.5"></path>
                <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" fill="#ffffff"></path>
            </svg>
        </div>
        <p class="fw-bold">CENTRO UNIVERSITARIO DE CIENCIAS SOCIALES Y HUMANIDADES</p>
        <p>Los Belenes. Av. José Parres Arias #150, San José del Bajío, Zapopan, Jalisco, México.</p>
        <p>© 1997 - 2025 Universidad de Guadalajara</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
