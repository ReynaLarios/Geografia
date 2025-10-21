<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Licenciatura en Geografía</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Banner */
        .banner {
            width: 100%;
            height: 400px;
            object-fit: cover;
            display: block;
        }

        /* Layout */
        .layout {
            display: flex;
            flex: 1;
        }

        .sidebar {
            width: 250px;
            background-color: #fff2e9;
            border-right: 1px solid #815638;
            padding: 20px;
        }

        .content {
            flex: 1;
            padding: 20px;
        }

        /* Fancy buttons en sidebar (ovalados y sin borde) */
        .fancy {
            background-color: #fff2e9;
            border: none;
            border-radius: 30px;
            color: #6b422d;
            cursor: pointer;
            display: block;
            margin: 8px 0;
            padding: 0.8em;
            position: relative;
            font-weight: 600;
            text-transform: uppercase;
            transition: all 0.3s ease-in-out;
            width: 100%;
            text-align: center;
            text-decoration: none;
        }

        .fancy:hover {
            background: #a66c47;
            color: #fff;
        }

        .fancy:active {
            transform: scale(0.95);
            background: #6b422d;
        }

        /* Navbar buttons (ovalados también) */
        .paste-button {
            position: relative;
            display: inline-block;
            margin: 0 5px;
        }

        .button {
            background-color: #815638;
            color: #fff;
            padding: 10px 20px;
            font-size: 15px;
            font-weight: bold;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            transition: background 0.3s, transform 0.1s;
        }

        .button:hover {
            background-color: #a66c47;
        }

        .button:active {
            transform: scale(0.95);
            background-color: #6b422d;
        }

        /* Dropdown */
        .dropdown-content {
            display: none;
            font-size: 13px;
            position: absolute;
            z-index: 1;
            min-width: 200px;
            background-color: #cca182;
            border-radius: 0px 15px 15px 15px;
            box-shadow: 0px 8px 16px rgba(15, 9, 34, 0.2);
        }

        .dropdown-content a {
            color: #ffffff;
            padding: 8px 10px;
            text-decoration: none;
            display: block;
            transition: 0.2s;
        }

        .dropdown-content a:hover {
            background-color: #5a412f;
            color: #ffffff;
        }

        .paste-button:hover .dropdown-content {
            display: block;
        }

        /* Input */
        .input-container {
            position: relative;
            display: flex;
            align-items: center;
            background: #fff;
            border-radius: 25px;
            padding: 5px 15px;
            border: 2px solid #595045;
            transition: 0.3s;
        }

        .input-container .input {
            border: none;
            outline: none;
            background: transparent;
            padding: 6px 10px;
            font-size: 15px;
            width: 200px;
            color: #432f1b;
        }

        .input-container .input::placeholder {
            color: #342114;
            font-style: italic;
        }

        .input-container:focus-within {
            border-color: #815638;
            box-shadow: 0 0 6px #53321480;
        }

        .input-container .icon {
            position: absolute;
            right: 10px;
            pointer-events: none;
            display: flex;
            align-items: center;
        }

        /* Footer */
        footer {
            position: relative;
            background: linear-gradient(135deg, #ad8466, #815638);
            color: white;
            padding: 40px 10px 20px 10px;
            overflow: hidden;
            text-align: center;
        }

        footer p {
            margin: 5px 0;
        }

        .wave {
            position: absolute;
            top: -30px;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
        }

        .wave svg {
            width: 100%;
            height: 80px;
        }

        @media (max-width: 768px) {
            .layout {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid #ddd;
            }

            .navbar .container-fluid {
                flex-direction: column;
                height: auto;
                padding: 10px;
            }

            .navbar-brand img {
                max-height: 90px;
                margin: 0 auto;
            }

            .input-container {
                margin-top: 10px;
                width: 100%;
            }

            .input-container .input {
                width: 100%;
            }
        }
    </style>
</head>
<link rel="stylesheet" href="{{ asset('css/app.css') }}">

<body>

    <nav class="navbar" style="background-color: #fff2e9; height: 60px; padding: 0;">
        <div class="container-fluid d-flex justify-content-between align-items-center" style="height: 80%; padding: 0;">
            <a class="navbar-brand d-flex align-items-center" href="https://www.udg.mx/"
                style="height: 100%; padding: 0;">
                <img src="Logo.png" style="max-height: 120px; margin-top: -10px;" alt="Logo">
            </a>

            <div class="input-container">
                <input type="text" name="text" class="input" placeholder="Buscar...">
                <span class="icon">
                    <svg width="19px" height="19px" viewBox="0 0 24 24" fill="none">
                        <path d="M14 5H20" stroke="#2d6a4f" stroke-width="1.5" stroke-linecap="round"></path>
                        <path d="M14 8H17" stroke="#2d6a4f" stroke-width="1.5" stroke-linecap="round"></path>
                        <path d="M21 11.5C21 16.75 16.75 21 11.5 21C6.25 21 2 16.75 2 11.5C2 6.25 6.25 2 11.5 2"
                            stroke="#2d6a4f" stroke-width="2.5" stroke-linecap="round"></path>
                        <path d="M22 22L20 20" stroke="#2d6a4f" stroke-width="3.5" stroke-linecap="round"></path>
                    </svg>
                </span>
            </div>
        </div>
    </nav>

    <img src="geo.jpg" alt="Imagen geografía" class="banner">

    <nav class="navbar navbar-expand-lg" style="background-color:#815638; border-bottom:1px solid #815638;">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menuPrincipal">
                <ul class="navbar-nav me-auto">
                    <div class="paste-button">
                        <a href="inicio">
                            <button class="button">INICIO</button>
                        </a>
                    </div>

                    <div class="paste-button">
                        <button class="button">ACERCA DE ▼</button>
                        <div class="dropdown-content">
                            <a href="/mision">Misión</a>
                            <a href="/vision">Visión</a>
                            <a href="/objetivos">Objetivos</a>
                            <a href="#">Órgano de gobierno del departamento</a>
                        </div>
                    </div>

                    <div class="paste-button">
                        <button class="button">ACADEMIA ▼</button>
                        <div class="dropdown-content">
                            <a href="#">Metodología y Didáctica</a>
                            <a href="#">Geografía física</a>
                            <a href="#">Territorio y Gestión</a>
                            <a href="#">Tecnologias de la Información Geográfica</a>
                        </div>
                    </div>

                    <div class="paste-button">
                        <button class="button">COORDINACIÓN ▼</button>
                        <div class="dropdown-content">
                            <a href="#">De Posgrado</a>
                            <a href="#">De Investigación</a>
                            <a href="#">De Extensión</a>
                        </div>
                    </div>

                    <div class="paste-button">
                        <button class="button">LABORATORIO \ CENTRO DE INVESTIGACION ▼</button>
                        <div class="dropdown-content">
                            <a href="#">Nuevas Tecnologías</a>
                            <a href="#">Tecnologías en geografía </a>
                            <a href="#">Geografía física </a>
                        </div>
                    </div>

                    <div class="paste-button">
                        <button class="button">DIRECTORIO ▼</button>
                        <div class="dropdown-content">
                            <a href="#">Administración</a>
                            <a href="#">Personal administrativo</a>
                            <a href="#">Académicos</a>
                        </div>
                    </div>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Layout -->
    </head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg" style="background-color:#815638;">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="{{ url('/') }}">Inicio</a>
            <!-- Puedes agregar dropdowns aquí si quieres -->
        </div>
    </nav>

    <!-- Layout -->
    <div class="layout">
        <!-- Sidebar -->
    <aside class="sidebar">

    @isset($seccion)
        <h4>{{ $seccion->nombre }}</h4>

        <!-- Botón agregar contenido -->
        <button class="fancy btn-agregar mb-3" onclick="window.location='{{ route('contenidos.crear') }}?seccion_id={{ $seccion->id }}'">
            + Agregar Contenido
        </button>

        <ul class="nav flex-column">
            @foreach($seccion->contenidos as $contenidoItem)
                <li class="mb-2 d-flex justify-content-between align-items-center">
                    <a href="{{ route('contenidos.{id}.mostrar', $contenidoItem->id) }}" class="fancy flex-grow-1">
                        {{ $contenidoItem->titulo }}
                    </a>
                    <div class="d-flex gap-1">
                        <!-- Editar -->
                        <a href="{{ route('contenidos.edit', $contenidoItem->id) }}" class="fancy btn-editar">✎</a>
                        <!-- Borrar -->
                        <form action="{{ route('contenidos.{id}.borrar', $contenidoItem->id) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres borrar este contenido?')">
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

        <!-- Botón agregar sección -->
        <button class="fancy btn-agregar mb-3" onclick="window.location='{{ route('secciones.crear') }}'">
            + Agregar Sección
        </button>

        <ul class="nav flex-column">
            @foreach($secciones ?? [] as $sec)
                <li class="mb-2 d-flex justify-content-between align-items-center">
                    url
                    if isset(inicio)?url = inicio :url = route('secciones.{id}.mostrar', $sec->id)
                    <a href="{{ route('secciones.{id}.mostrar', $sec->id) }}" class="fancy flex-grow-1">
                        {{ $sec->nombre }}
                    </a>
                    <div class="d-flex gap-1">
                        <!-- Editar sección -->
                        <a href="{{ route('secciones.{id}.editar', $sec->id) }}" class="fancy btn-editar">✎</a>
                        <!-- Borrar sección -->
                        <form action="{{ route('secciones.{id}.borrar', $sec->id) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres borrar esta sección?')">
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



        <!-- Main content -->
        <main class="content">
            @yield('contenido')
        </main>
    </div>

    <!-- Footer -->
    <footer class="text-center p-4" style="background:#815638; color:white;">
        © 1997 - 2025 Universidad de Guadalajara
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
