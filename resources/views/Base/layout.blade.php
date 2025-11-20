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

body { margin:0; display:flex; flex-direction:column; min-height:100vh; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: var(--gris-claro); color: #1e293b; }
.navbar-top { background-color: var(--blanco); box-shadow:0 2px 4px var(--sombra); padding:0.5rem 1rem; }
.navbar-top img { max-height:90px; }
.navbar-top .button { background: var(--azul-medio); color: var(--blanco); border:none; border-radius:25px; padding:8px 20px; font-weight:600; }
.navbar-top .button:hover { background: var(--azul-oscuro); transform: scale(1.05); }

.banner { width:100%; height:350px; object-fit:cover; display:block; }

.navbar-bottom { background-color: var(--azul-oscuro); padding:1rem; display:flex; flex-wrap:wrap; gap:10px; justify-content:center; }
.navbar-bottom .paste-button { position: relative; display:inline-block; }
.navbar-bottom .button { background-color: var(--azul-oscuro); color: var(--blanco); border:none; border-radius:25px; padding:12px 25px; font-weight:500; text-transform:uppercase; cursor:pointer; box-shadow:0 2px 6px rgba(0,0,0,0.15); }
.navbar-bottom .button:hover { background-color: var(--azul-suave); color: var(--azul-oscuro); }
.dropdown-content { display:none; position:absolute; z-index:10; min-width:200px; background-color: var(--azul-medio); border-radius:10px; top:45px; left:50%; transform: translateX(-50%); }
.dropdown-content a { color: var(--blanco); padding:10px 15px; display:block; text-decoration:none; }
.paste-button:hover .dropdown-content { display:block; }

.layout { display:flex; flex:1; background: var(--blanco); }
.sidebar { width:260px; background-color: var(--blanco); border-right:1px solid var(--gris-medio); padding:20px; }
.sidebar h4 { color: var(--azul-oscuro); font-weight:600; margin-bottom:1rem; border-bottom:2px solid var(--azul-medio); padding-bottom:5px; }

.fancy { background-color: var(--azul-suave); border:none; border-radius:25px; color: var(--azul-oscuro); font-weight:500; text-transform:uppercase; padding:10px 15px; margin:8px 0; width:100%; text-align:center; text-decoration:none; display:block; transition: background 0.3s, transform 0.2s; }
.fancy:hover { background-color: var(--azul-medio); color: var(--blanco); transform: translateY(-2px); }
.fancy.btn-borrar { background-color:#fee2e2; color:#b91c1c; }
.fancy.btn-borrar:hover { background-color:#ef4444; color:#fff; }

.small-btn { border:none; background:#60a5fa; color:white; border-radius:10px; padding:3px 6px; font-size:12px; cursor:pointer; display:inline-flex; align-items:center; justify-content:center; }
.small-btn:hover { background:#1e3a8a; }

.content { flex:1; padding:30px; background: var(--gris-claro); }

footer { position:relative; background:linear-gradient(135deg, #60a5fa, #1e3a8a); color:white; padding:40px 10px 20px 10px; text-align:center; overflow:hidden; }
.wave { position:absolute; top:-30px; left:0; width:100%; overflow:hidden; line-height:0; }
.wave svg { width:100%; height:80px; }

@media (max-width:768px){ .layout{ flex-direction:column; } .sidebar{ width:100%; border-right:none; border-bottom:1px solid var(--gris-medio); } .navbar-bottom{ flex-direction: column; gap:8px; } }

.section-hover .section-actions { display:none; margin-top:4px; }
.section-hover:hover .section-actions { display:block; }
</style>
</head>
<body>

{{-- NAVBAR SUPERIOR --}}
<nav class="navbar navbar-top d-flex justify-content-between align-items-center" style="padding:0.25rem 1rem; height:70px;">
    <a href="https://www.udg.mx/es" class="navbar-brand d-flex align-items-center">
        <img src="{{ asset('/logo.png') }}" alt="Logo" style="height:70px;">
    </a>
<div class="mb-3">
    <input type="text" id="buscador-admin" placeholder="Buscar en admin..." style="padding:5px 10px; width:300px; border-radius:25px; border:1px solid #f87171;">
</div>

<ul id="resultados-admin"></ul>

<script>
$(document).ready(function(){
    $('#buscador-admin').on('keyup', function(){
        let query = $(this).val();
        $.ajax({
            url: "{{ route('admin.buscar') }}",
            type: "GET",
            data: { query: query },
            success: function(data){
                $('#resultados-admin').html(data.html);
            }
        });
    });
});
</script>

        <form action="{{ route('logout') }}" method="POST">@csrf
            <button type="submit" class="button" style="padding:6px 15px; font-size:0.9rem;">Cerrar sesión</button>
        </form>
    </div>
</nav>

@php 
use App\Models\Banner;
$banner = Banner::latest()->first();
@endphp

<div class="banner-container position-relative" style="width:100%; max-height:350px; overflow:hidden; border-radius:8px;">
    @if($banner && $banner->imagen && file_exists(storage_path('app/public/banners/' . $banner->imagen)))
        <img src="{{ asset('storage/banners/' . $banner->imagen) }}" class="banner img-fluid" alt="Banner">
    @else
        <img src="{{ asset('images/banner-default.jpg') }}" class="banner img-fluid" alt="Banner por defecto">
    @endif

    <!-- Botones de acción sobre el banner -->
    <div style="position:absolute; top:10px; right:10px; display:flex; gap:5px;">
        <!-- Editar -->
        <a href="{{ route('banner.index') }}" class="small-btn" title="Administrar banner">✏️</a>

        <!-- Borrar -->
        @if($banner)
        <form action="{{ route('banner.borrar') }}" method="POST" onsubmit="return confirm('¿Seguro que quieres borrar este banner?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="small-btn btn-borrar">🗑️</button>
        </form>
        @endif
    </div>
</div>



{{-- NAVBAR INFERIOR --}}
<nav class="navbar-bottom">

    <!-- Botón para agregar nueva sección -->
    <div class="paste-button">
        <button class="button" onclick="window.location='{{ route('navbar.secciones.crear') }}'">+ Agregar Sección Navbar</button>
    </div>

    @foreach($navbarSecciones ?? [] as $sec)
    <div class="paste-button section-hover" style="position: relative; margin-bottom:5px;">

        <!-- Botón principal de la sección -->
        <button class="button" onclick="window.location='{{ route('navbar.secciones.mostrar', $sec->id) }}'">
            {{ $sec->nombre }} @if($sec->contenidosNavbar && $sec->contenidosNavbar->count()) ▼ @endif
        </button>

        <!-- Botones de acción de la sección -->
        <div class="section-actions" style="margin-top:5px;">
            <div style="display:flex; gap:2px; flex-wrap:wrap; margin-bottom:4px;">
                <button title="Editar sección" class="small-btn" onclick="window.location='{{ route('navbar.secciones.editar', $sec->id) }}'">✏️</button>

                <form action="{{ route('navbar.secciones.borrar', $sec->id) }}" method="POST">@csrf @method('DELETE')
                    <button type="submit" class="small-btn btn-borrar">🗑️</button>
                </form>

                <button class="small-btn toggle-visibility" data-id="{{ $sec->id }}" data-model="NavbarSeccion"
                        style="{{ $sec->oculto_publico ? 'opacity:0.4;' : '' }}">👁</button>

                <a href="{{ route('navbar.contenidos.crear') }}?seccion_id={{ $sec->id }}" class="small-btn">+</a>
            </div>

            <!-- Submenu de contenidos -->
            @if($sec->contenidosNavbar && $sec->contenidosNavbar->count())
            <div class="dropdown-content" style="position:relative; display:block; margin-top:4px; padding:5px 10px; border-radius:8px; background-color: #60a5fa;">
                @foreach($sec->contenidosNavbar as $contenido)
                <div style="display:flex; align-items:center; justify-content:space-between; gap:2px; margin:2px 0; padding:3px 6px; border-radius:6px; background: rgba(255,255,255,0.15);">
                    
                    <!-- Título del contenido -->
                    <a href="{{ route('navbar.contenidos.mostrar', $contenido->id) }}" style="flex-grow:1; color:white; text-decoration:none;">
                        {{ $contenido->titulo }}
                    </a>

                    <!-- Botones del contenido -->
                    <div style="display:flex; gap:2px;">
                        <button title="Editar contenido" class="small-btn" onclick="window.location='{{ route('navbar.contenidos.editar', $contenido->id) }}'">✏️</button>

                        <form action="{{ route('navbar.contenidos.borrar', $contenido->id) }}" method="POST">@csrf @method('DELETE')
                            <button type="submit" class="small-btn btn-borrar">🗑️</button>
                        </form>

                        <button class="small-btn toggle-visibility" data-id="{{ $contenido->id }}" data-model="NavbarContenido"
                                style="{{ $contenido->oculto_publico ? 'opacity:0.4;' : '' }}">👁</button>
                    </div>

                </div>
                @endforeach
            </div>
            @endif

        </div>
    </div>
    @endforeach

</nav>


<div class="layout">
    <aside class="sidebar">
        <h4>Secciones</h4>
        @if(isset($seccion))
        <button class="fancy mb-2" onclick="window.location='{{ route('contenidos.crear') }}?seccion_id={{ $seccion->id }}'">+ Agregar Contenido</button>
        <button class="fancy mb-2" onclick="window.location='{{ route('dashboard') }}'">← Regresar a Secciones</button>

        <ul class="nav flex-column">
            @foreach($seccion->contenidos ?? [] as $cont)
            <li class="mb-2 d-flex justify-content-between align-items-center">
                <a href="{{ route('contenidos.mostrar', $cont->id) }}" class="fancy flex-grow-1">{{ $cont->titulo }}</a>
                <div class="d-flex gap-1">
                    <a href="{{ route('contenidos.editar', $cont->id) }}" class="small-btn">✏️</a>
                    <form action="{{ route('contenidos.borrar', $cont->id) }}" method="POST">@csrf @method('DELETE')
                        <button class="small-btn btn-borrar" type="submit">🗑</button>
                    </form>
                    <button class="small-btn toggle-visibility" data-id="{{ $cont->id }}" data-model="Contenido" style="{{ $cont->oculto_publico ? 'opacity:0.4;' : '' }}">👁</button>
                </div>
            </li>
            @endforeach
        </ul>
        @else
        <button class="fancy mb-2" onclick="window.location='{{ route('secciones.crear') }}'">+ Agregar Sección</button>

        <ul class="nav flex-column">
            @foreach($secciones ?? [] as $sec)
            <li class="mb-2 d-flex justify-content-between align-items-center">
                <a href="{{ route('secciones.mostrar', $sec->id) }}" class="fancy flex-grow-1">{{ $sec->nombre }}</a>
                <div class="d-flex gap-1">
                    <a href="{{ route('secciones.editar', $sec->id) }}" class="small-btn">✏️</a>
                    <form action="{{ route('secciones.borrar', $sec->id) }}" method="POST">@csrf @method('DELETE')
                        <button class="small-btn btn-borrar" type="submit">🗑</button>
                    </form>
                    <button class="small-btn toggle-visibility" data-id="{{ $sec->id }}" data-model="Seccion" style="{{ $sec->oculto_publico ? 'opacity:0.4;' : '' }}">👁</button>
                </div>
            </li>
            @endforeach
        </ul>
        @endif
    </aside>

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

<script>
document.querySelectorAll('.toggle-visibility').forEach(btn=>{
    btn.addEventListener('click', function(){
        const id = this.dataset.id;
        const model = this.dataset.model;

        fetch('{{ route("toggle-visibility") }}', {
            method:'POST',
            headers:{
                'Content-Type':'application/json',
                'X-CSRF-TOKEN':'{{ csrf_token() }}'
            },
            body: JSON.stringify({id, model})
        })
        .then(res=>res.json())
        .then(data=>{
            if(data.ok){
                this.style.opacity = data.oculto_publico ? 0.4 : 1;
            }
        });
    });
});
</script>

@yield('scripts')

</body>
</html>
