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

    .navbar-top .button {
      background: var(--azul-medio);
      color: var(--blanco);
      border: none;
      border-radius: 25px;
      padding: 8px 20px;
      font-weight: 600;
      transition: background 0.3s ease, transform 0.2s;
    }

    .navbar-top .button:hover {
      background: var(--azul-oscuro);
      transform: scale(1.05);
    }

    
    .navbar-bottom {
      background-color: var(--azul-oscuro);
      border-bottom: 3px solid var(--azul-medio);
      font-size: 15px;
    }

    .navbar-bottom .button {
      background: transparent;
      color: var(--blanco);
      border: none;
      font-weight: 500;
      text-transform: uppercase;
      padding: 8px 14px;
      transition: color 0.3s ease;
    }

    .navbar-bottom .button:hover {
      color: var(--azul-medio);
    }

    .dropdown-content {
      display: none;
      position: absolute;
      z-index: 10;
      min-width: 220px;
      background-color: var(--azul-medio);
      border-radius: 10px;
      box-shadow: 0 4px 10px var(--sombra);
    }

    .dropdown-content a {
      color: var(--blanco);
      padding: 10px 15px;
      display: block;
      text-decoration: none;
      transition: background 0.3s;
    }

    .dropdown-content a:hover {
      background-color: var(--azul-oscuro);
    }

    .paste-button:hover .dropdown-content {
      display: block;
    }

 
    .input-container {
      display: flex;
      align-items: center;
      background: var(--gris-claro);
      border-radius: 25px;
      padding: 5px 15px;
      border: 1px solid var(--azul-medio);
      transition: box-shadow 0.3s ease;
    }

    .input-container input {
      border: none;
      outline: none;
      background: transparent;
      padding: 6px 10px;
      width: 180px;
      color: #1e293b;
    }

    .input-container input::placeholder {
      color: #9ca3af;
    }

    .input-container:focus-within {
      box-shadow: 0 0 6px var(--azul-medio);
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

    
    footer {
      background: var(--azul-oscuro);
      color: var(--blanco);
      text-align: center;
      padding: 20px;
      font-size: 0.9rem;
      border-top: 3px solid var(--azul-medio);
    }

    @media (max-width: 768px) {
      .layout {
        flex-direction: column;
      }

      .sidebar {
        width: 100%;
        border-right: none;
        border-bottom: 1px solid var(--gris-medio);
      }
    }
    <style>
.contenido-descripcion {
  font-size: 1rem;
  line-height: 1.6;
  color: #333;
}

.contenido-descripcion strong {
  font-weight: bold;
}

.contenido-descripcion a {
  color: #007bff;
  text-decoration: underline;
}

.contenido-descripcion ul {
  margin-left: 1.5rem;
  list-style-type: disc;
}
</style>

  </style>
</head>

<body>

  <nav class="navbar navbar-top d-flex justify-content-between align-items-center">
    <a href="https://www.udg.mx/" class="navbar-brand d-flex align-items-center">
      <img src="Logo.png" alt="Logo">
    </a>

    <div class="d-flex align-items-center gap-3">
      <div class="input-container">
        <input type="text" placeholder="Buscar...">
        <svg width="18" height="18" fill="none" stroke="#1e3a8a" stroke-width="2" stroke-linecap="round"
          stroke-linejoin="round" viewBox="0 0 24 24">
          <circle cx="11" cy="11" r="8"></circle>
          <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
      </div>

      <div class="paste-button position-relative">
        <button class="button">Cerrar sesión</button>
        <div class="dropdown-content" style="right: 0;">
          <form action="{{ route('logout') }}" method="POST" style="margin:0;">
            @csrf
            <button type="submit"
              style="background:none; border:none; color:white; padding:8px 10px; width:100%; text-align:left; cursor:pointer;">
              Cerrar Sesión
            </button>
          </form>
        </div>
      </div>
    </div>
  </nav>


  <nav class="navbar navbar-bottom navbar-expand-lg">
    <div class="container-fluid">
      <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="menuPrincipal">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="button nav-link text-white" href="{{ url('/administrador/dashboard') }}">Inicio</a>
          </li>

          <div class="paste-button">
            <button class="button">Acerca de ▼</button>
            <div class="dropdown-content">
              <a href="/mision">Misión</a>
              <a href="/vision">Visión</a>
              <a href="/objetivos">Objetivos</a>
              <a href="#">Órgano de gobierno</a>
            </div>
          </div>

          <div class="paste-button">
            <button class="button">Academia ▼</button>
            <div class="dropdown-content">
              <a href="#">Metodología y Didáctica</a>
              <a href="#">Geografía física</a>
              <a href="#">Territorio y Gestión</a>
              <a href="#">Tecnologías de la Información Geográfica</a>
            </div>
          </div>
        </ul>
      </div>
    </div>
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
    Derechos reservados ©1997 - 2025. Universidad de Guadalajara. Sitio desarrollado por 
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
