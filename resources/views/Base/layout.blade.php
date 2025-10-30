<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Licenciatura en Geografía</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root {
      --color-fondo: #f5e9d3;       /* beige claro */
      --color-principal: #fbbf88;    /* naranja pastel */
      --color-secundario: #ffe8a1;   /* amarillo pastel */
      --color-acento: #a3c4f3;       /* azul pastel */
      --color-texto: #5a4d41;        /* marrón grisáceo suave */
      --color-blanco: #ffffff;
    }

    body {
      margin: 0;
      font-family: 'Inter', 'Segoe UI', sans-serif;
      background: var(--color-fondo);
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    /* Navbar superior */
    .navbar-top {
      background: var(--color-blanco);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      padding: 10px 30px;
      border-radius: 0 0 20px 20px;
    }

    .navbar-top .btn {
      border-radius: 50px;
      padding: 8px 20px;
      font-weight: 500;
      transition: 0.3s;
    }

    .btn-primario {
      background: var(--color-principal);
      color: var(--color-blanco);
    }

    .btn-primario:hover {
      background: var(--color-acento);
      color: var(--color-blanco);
    }

    /* Hero/banner */
    .hero {
      position: relative;
      width: 100%;
      height: 350px;
      background: url('banner.jpg') center/cover no-repeat;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--color-blanco);
      text-shadow: 0 2px 8px rgba(0, 0, 0, 0.4);
      border-radius: 20px;
      margin: 20px;
      overflow: hidden;
    }

    .hero::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.2); /* overlay suave */
      z-index: 1;
    }

    .hero h1 {
      font-size: 2.8rem;
      font-weight: 700;
      text-align: center;
      position: relative;
      z-index: 2;
    }

    /* Navbar inferior / menú principal */
    .navbar-main {
      background: var(--color-secundario);
      border-bottom: 3px solid var(--color-principal);
      border-radius: 15px;
      margin: 0 20px 20px 20px;
      padding: 10px 20px;
    }

    .navbar-main .nav-link {
      color: var(--color-texto);
      font-weight: 600;
      transition: 0.3s;
    }

    .navbar-main .nav-link:hover {
      color: var(--color-principal);
    }

    /* Layout */
    .layout {
      display: flex;
      flex: 1;
      gap: 20px;
      padding: 0 20px 20px 20px;
    }

    /* Sidebar */
    .sidebar {
      width: 260px;
      background: var(--color-blanco);
      border-radius: 15px;
      padding: 25px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      height: fit-content;
      position: sticky;
      top: 20px;
    }

    .sidebar h4 {
      color: var(--color-principal);
      font-weight: 700;
      margin-bottom: 20px;
    }

    .sidebar a {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 15px;
      margin-bottom: 8px;
      border-radius: 12px;
      text-decoration: none;
      color: var(--color-texto);
      transition: all 0.2s;
      background: var(--color-fondo);
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
    }

    .sidebar a:hover {
      background: var(--color-secundario);
      color: var(--color-principal);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .sidebar .btn-agregar {
      width: 100%;
      margin-bottom: 15px;
      border-radius: 25px;
      font-weight: 600;
      background: var(--color-principal);
      color: var(--color-blanco);
    }

    .sidebar .btn-agregar:hover {
      background: var(--color-acento);
      color: var(--color-blanco);
    }

    /* Contenido principal */
    .content {
      flex: 1;
      padding: 30px;
      border-radius: 15px;
      background: var(--color-blanco);
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    /* Footer */
    footer {
      text-align: center;
      padding: 20px 0;
      background: var(--color-principal);
      color: var(--color-blanco);
      font-size: 14px;
      border-radius: 15px 15px 0 0;
      margin: 20px;
    }

    /* Responsive */
    @media (max-width: 992px) {
      .layout {
        flex-direction: column;
      }

      .sidebar {
        width: 100%;
        margin-bottom: 20px;
      }

      .hero h1 {
        font-size: 2rem;
        padding: 0 10px;
      }

      .navbar-main {
        margin: 0 10px 10px 10px;
      }
    }
  </style>
</head>

<body>

  <!-- Navbar superior -->
  <nav class="navbar navbar-top d-flex justify-content-between align-items-center">
    <a class="navbar-brand d-flex align-items-center" href="https://www.udg.mx/">
      <img src="Logo.png" alt="Logo" style="max-height:70px;">
    </a>

    <div class="d-flex align-items-center gap-3">
      <input type="text" class="form-control rounded-pill" placeholder="Buscar..." style="width:200px;">
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primario">Cerrar sesión</button>
      </form>
    </div>
  </nav>

  <!-- Hero / Banner -->
  <div class="hero">
    <h1>Licenciatura en Geografía</h1>
  </div>

  <!-- Navbar inferior / Menú principal -->
  <nav class="navbar navbar-main navbar-expand-lg">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="menuPrincipal">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="{{ url('/administrador/dashboard') }}">Inicio</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Acerca de</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="/mision">Misión</a></li>
              <li><a class="dropdown-item" href="/vision">Visión</a></li>
              <li><a class="dropdown-item" href="/objetivos">Objetivos</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Layout -->
  <div class="layout">
    <!-- Sidebar -->
    <aside class="sidebar">
      @isset($seccion)
      <h4>{{ $seccion->nombre }}</h4>
      <button class="btn btn-agregar"
        onclick="window.location='{{ route('contenidos.crear') }}?seccion_id={{ $seccion->id }}'">
        + Agregar Contenido
      </button>

      <ul class="list-unstyled">
        @foreach($seccion->contenidos as $contenidoItem)
        <li>
          <a href="{{ route('contenidos.mostrar', $contenidoItem->id) }}">
            {{ $contenidoItem->titulo }}
            <span>
              <i class="bi bi-pencil-square text-warning me-2"></i>
              <form action="{{ route('contenidos.borrar', $contenidoItem->id) }}" method="POST"
                style="display:inline;" onsubmit="return confirm('¿Seguro?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-link p-0 m-0 text-danger"><i class="bi bi-trash"></i></button>
              </form>
            </span>
          </a>
        </li>
        @endforeach
      </ul>
      @else
      <h4>Secciones</h4>
      <button class="btn btn-agregar" onclick="window.location='{{ route('secciones.crear') }}'">
        + Agregar Sección
      </button>

      <ul class="list-unstyled">
        @foreach($secciones ?? [] as $sec)
        <li>
          <a href="{{ route('secciones.mostrar', $sec->id) }}">
            {{ $sec->nombre }}
            <span>
              <i class="bi bi-pencil-square text-warning me-2"></i>
              <form action="{{ route('secciones.borrar', $sec->id) }}" method="POST" style="display:inline;"
                onsubmit="return confirm('¿Seguro?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-link p-0 m-0 text-danger"><i class="bi bi-trash"></i></button>
              </form>
            </span>
          </a>
        </li>
        @endforeach
      </ul>
      @endisset
    </aside>

    <!-- Contenido principal -->
    <main class="content">
      @yield('contenido')
    </main>
  </div>

  <!-- Footer -->
  <footer>
    © 1997 - 2025 Universidad de Guadalajara
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
