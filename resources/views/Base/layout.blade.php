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
                        <button class="button">LABORATORIO ▼</button>
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
    <div class="layout">
        <!-- Sidebar izquierda -->
        <aside class="sidebar">
            <ul class="nav flex-column">
                <li><a href="licenciatura" class="fancy">Licenciatura en Geografía</a></li>
                <li><a href="conoce" class="fancy">Conoce la Licenciatura</a></li>
                <li><a href="alumnos" class="fancy">Alumnos</a></li>
                <li><a href="horarios.html" class="fancy">Horarios</a></li>
                <li><a href="cursos.html" class="fancy">Cursos de Inducción</a></li>
                <li><a href="normatividad.html" class="fancy">Normatividad</a></li>
                <li><a href="egresados.html" class="fancy">Egresados</a></li>
                <li><a href="consejo.html" class="fancy">Maestría en Desarrollo Local y Territorio</a></li>
                <li><a href="revista.html" class="fancy">Revista Geocalli</a></li>
                <li><a href="videoteca" class="fancy">Videoteca</a></li>
                <li><a href="investigacion.html" class="fancy">Investigación</a></li>
                <li><a href="publicaciones.html" class="fancy">Publicaciones Geográficas</a></li>
            </ul>
        </aside>

        <!-- Contenido -->
        <main class="content">
            @yield('contenido')
        </main>
    </div>

    <!-- Footer -->
    <footer>
        <div class="wave">
            <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path
                    d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z"
                    fill="#fdf6ef" opacity="0.25"></path>
                <path
                    d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z"
                    fill="#fdf6ef" opacity="0.5"></path>
                <path
                    d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z"
                    fill="#fdf6ef"></path>
            </svg>
        </div>
        <p class="fw-bold">CENTRO UNIVERSITARIO DE CIENCIAS SOCIALES Y HUMANIDADES</p>
        <p>Los Belenes. Av. José Parres Arias #150, San José del Bajío, Zapopan, Jalisco, México.</p>
        <p>© 1997 - 2025 Universidad de Guadalajara</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
