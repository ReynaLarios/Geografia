<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Departamento de geografia y ordenación territorial</title>

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

.banner { width:100%; object-fit:contain; display:block; }

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

.navbar-bottom {
    display: flex;
    flex-wrap: wrap;
    gap: 18px; 
}


</style>
</head>
<body>


<nav class="navbar navbar-top d-flex justify-content-between align-items-center" style="padding:0.25rem 1rem; height:70px;">
    <a href="https://www.udg.mx/es" class="navbar-brand d-flex align-items-center">
        <img src="{{ asset('/logo.png') }}" alt="Logo" style="height:70px;">
    </a>
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
.small-btn{
    font-size: 0.7rem;
    padding: 3px 8px;
    border-radius: 8px;
    background:#e5e7eb;
    color:#1e3a8a;
}
.small-btn:hover{
    background:#dbeafe;
}

.imagen-cuadrada {
    width: 100%;
    max-width: 250px;     /* tamaño máximo */
    aspect-ratio: 1 / 1;  /* siempre cuadrado */
    overflow: hidden;
    border-radius: 8px;
    background-color: #f0f0f0;
    margin: 10px auto;
}

.imagen-cuadrada img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.dropdown-small-text .dropdown-item {
    font-size: 12px;
    padding: 6px 14px;
}

</style>

        <form action="{{ route('logout') }}" method="POST">@csrf
            <button type="submit" class="button" style="padding:6px 15px; font-size:0.9rem;">Cerrar sesión</button>
        </form>
    </div>
</nav>
<nav class="navbar border-bottom"
     style="background:#f5f6fa; padding:4px 12px; min-height:36px;">
    <div class="container-fluid d-flex justify-content-start gap-2 align-items-center">

        <button class="small-btn"
                onclick="window.location='{{ route('navbar.secciones.crear') }}'">
            + Sección Horizontal
        </button>

        <button class="small-btn"
                onclick="window.location='{{ route('navbar.contenidos.crear') }}'">
            + Sub-Sección H
        </button>

        <button class="small-btn"
                onclick="window.location='{{ route('secciones.crear') }}'">
            + Sección Vertical
        </button>

        <button class="small-btn"
                onclick="window.location='{{ route('contenidos.crear') }}'">
            + Sub-Sección V
        </button>

        <button class="small-btn"
                onclick="window.location='{{ route('personas.crear') }}'">
            + Académico
        </button>

        <!-- 🔽 DROPDOWN APARTE -->
        <div class="dropdown ms-2">
            <button class="small-btn dropdown-toggle"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">
         Listados
            </button>

           <ul class="dropdown-menu shadow-sm dropdown-small-text">
     <li><a class="dropdown-item" href="{{ route('navbar.secciones.index') }}">Secciones H</a></li>
    <li><a class="dropdown-item" href="{{ route('navbar.contenidos.index') }}">Contenidos H</a></li>
    <li><a class="dropdown-item" href="{{ route('secciones.listado') }}">Secciones V</a></li>
    <li><a class="dropdown-item" href="{{ route('contenidos.listado') }}">Contenidos V</a></li>
   
</ul>

        </div>

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
        <img src="{{ asset('Geo.jpg') }}" class="banner img-fluid" alt="Banner por defecto">
    @endif

 
    <div style="position:absolute; top:10px; right:10px; display:flex; gap:5px;">
   
        <a href="{{ route('banner.index') }}" class="small-btn" title="Administrar banner">✏️</a>

  
        @if($banner)
        <form action="{{ route('banner.borrar') }}" method="POST" onsubmit="return confirm('¿Seguro que quieres borrar este banner?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="small-btn btn-borrar">🗑️</button>
        </form>
        @endif
    </div>
</div>



<nav class="navbar-bottom">

    <div class="paste-button">
        <button class="button"
                onclick="window.location='{{ route('inicio.index') }}'">
            Inicio
        </button>
    </div>

    @foreach($navbarSecciones ?? [] as $sec)
        <div class="paste-button section-hover"
             style="{{ $sec->oculto_publico ? 'opacity:0.5;' : '' }}">

            <button class="button"
                    onclick="window.location='{{ route('navbar.secciones.mostrar', $sec->slug) }}'">
                {{ $sec->nombre }}
                @if($sec->contenidosNavbar && $sec->contenidosNavbar->where('oculto_publico', 0)->count())
                    ▼
                @endif
            </button>

            {{-- acciones admin --}}
            <div class="section-actions">

                <div style="display:flex; gap:4px; margin-top:4px; justify-content:center;">

                    <a href="{{ route('navbar.secciones.editar', $sec->slug) }}"
                       class="small-btn">✏️</a>

                    <form action="{{ route('navbar.secciones.borrar', $sec->slug) }}"
                          method="POST">
                        @csrf @method('DELETE')
                        <button class="small-btn btn-borrar">🗑</button>
                    </form>

                    <button class="small-btn toggle-visibility"
                            data-id="{{ $sec->id }}"
                            data-model="NavbarSeccion"
                            style="{{ $sec->oculto_publico ? 'opacity:0.4;' : '' }}">
                        👁
                    </button>

                </div>

                @if($sec->contenidosNavbar && $sec->contenidosNavbar->count())
                    <div class="dropdown-content">
                        @foreach($sec->contenidosNavbar as $contenido)
                            <div style="display:flex; align-items:center; justify-content:space-between; gap:4px;">
                                <a href="{{ route('navbar.contenidos.mostrar', $contenido->slug) }}"
                                   style="flex-grow:1;">
                                    {{ $contenido->titulo }}
                                </a>

                                <div style="display:flex; gap:2px;">
                                    <a href="{{ route('navbar.contenidos.editar', $contenido->slug) }}"
                                       class="small-btn">✏️</a>

                                    <form action="{{ route('navbar.contenidos.borrar', $contenido->slug) }}"
                                          method="POST">
                                        @csrf @method('DELETE')
                                        <button class="small-btn btn-borrar">🗑</button>
                                    </form>

                                    <button class="small-btn toggle-visibility"
                                            data-id="{{ $contenido->id }}"
                                            data-model="NavbarContenido"
                                            style="{{ $contenido->oculto_publico ? 'opacity:0.4;' : '' }}">
                                        👁
                                    </button>
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

    <div class="contenido-fixed">
        <button class="fancy"
                onclick="window.location='{{ route('personas.index') }}'">
            Académicos
        </button>
    </div>

    <hr style="border:0; height:2px; background:#90caf9; margin:12px 0; border-radius:4px;">

    @if(isset($seccion))

        <button class="fancy mb-2"
                onclick="window.location='{{ route('dashboard') }}'">
            ← Regresar a Secciones
        </button>

        <ul class="nav flex-column">
            @foreach($seccion->contenidos ?? [] as $cont)
                <li class="mb-2 d-flex justify-content-between align-items-center">

                    <a href="{{ route('contenidos.mostrar', $cont->slug) }}"
                       class="fancy flex-grow-1">
                        {{ $cont->titulo }}
                    </a>

                    <div class="d-flex gap-1">
                        <a href="{{ route('contenidos.editar', $cont->slug) }}"
                           class="small-btn">✏️</a>

                        <form action="{{ route('contenidos.borrar', $cont->slug) }}"
                              method="POST">
                            @csrf @method('DELETE')
                            <button class="small-btn btn-borrar">🗑</button>
                        </form>

                        <button class="small-btn toggle-visibility"
                                data-id="{{ $cont->id }}"
                                data-model="Contenido"
                                style="{{ $cont->oculto_publico ? 'opacity:0.4;' : '' }}">
                            👁
                        </button>
                    </div>
                </li>
            @endforeach
        </ul>

    @else

        <ul class="nav flex-column">
            @foreach($secciones ?? [] as $sec)
                <li class="mb-2 d-flex justify-content-between align-items-center">

                    <a href="{{ route('secciones.mostrar', $sec->slug) }}"
                       class="fancy flex-grow-1">
                        {{ $sec->nombre }}
                    </a>

                    <div class="d-flex gap-1">
                        <a href="{{ route('secciones.editar', $sec->slug) }}"
                           class="small-btn">✏️</a>

                        <form action="{{ route('secciones.borrar', $sec->slug) }}"
                              method="POST">
                            @csrf @method('DELETE')
                            <button class="small-btn btn-borrar">🗑</button>
                        </form>

                        <button class="small-btn toggle-visibility"
                                data-id="{{ $sec->id }}"
                                data-model="Seccion"
                                style="{{ $sec->oculto_publico ? 'opacity:0.4;' : '' }}">
                            👁
                        </button>
                    </div>
                </li>
            @endforeach
        </ul>

    @endif

    <hr style="border:0; height:2px; background:#90caf9; margin:12px 0; border-radius:4px;">

    <div class="videoteca-fixed">
        <button class="fancy"
                onclick="window.location='{{ route('videoteca.index') }}'">
            Videoteca
        </button>
    </div>

</aside>



    <main class="content">
        @yield('contenido')
    </main>
</div>

<footer style="position: relative; background-color:#60a5fa; color:white; text-align:center; padding-top:80px; padding-bottom:30px; overflow:hidden; font-family:sans-serif;">

    <div class="wave" style="position:absolute; top:0; left:0; width:100%; height:100px; overflow:hidden; line-height:0;">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" style="width:100%; height:100%;">
     
            <path d="M0,0V35c150,20,300,25,450,10s300-25,450,10s300,25,450,0V0Z" fill="#ffffff" opacity="0.08"></path>
        
            <path d="M0,0V30c150,18,300,20,450,5s300-20,450,5s300,18,450,0V0Z" fill="#ffffff" opacity="0.12"></path>
        
            <path d="M0,0V25c150,15,300,15,450,0s300-15,450,0s300,15,450,0V0Z" fill="#ffffff" opacity="0.16"></path>
       
            <path d="M0,0V20c150,12,300,12,450,0s300-12,450,0s300,12,450,0V0Z" fill="#ffffff" opacity="0.20"></path>
          
            <path d="M0,0V15c150,10,300,10,450,0s300-10,450,0s300,10,450,0V0Z" fill="#ffffff" opacity="0.25"></path>
        </svg>
    </div>

    <div style="position: relative; z-index: 1; max-width:800px; margin:0 auto; line-height:1.5;">
        <p class="fw-bold mb-1" style="font-size:1rem; letter-spacing:1px;">CENTRO UNIVERSITARIO DE CIENCIAS SOCIALES Y HUMANIDADES</p>
        <p class="mb-1" style="font-size:0.9rem;">Los Belenes. Av. José Parres Arias #150, Zapopan, Jalisco, México.</p>
        <p style="font-size:0.85rem;">© 1997 - 2025 Universidad de Guadalajara</p>
    </div>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>




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
