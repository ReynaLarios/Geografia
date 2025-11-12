<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="{{ route('public.inicio') }}">Geografía</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarPublico" aria-controls="navbarPublico" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarPublico">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                {{-- Recorrer todas las secciones del navbar --}}
                @foreach ($navbarSecciones as $seccion)
                    @php
                        $submenus = $navbarContenidos->where('navbar_seccion_id', $seccion->id);
                    @endphp

                    @if ($submenus->isNotEmpty())
                        <!-- Dropdown para secciones con submenús -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown{{ $seccion->id }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ $seccion->nombre }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown{{ $seccion->id }}">
                                @foreach ($submenus as $submenu)
                                    <li>
                                        <a class="dropdown-item" href="{{ route('public.verContenido', $submenu->id) }}">
                                            {{ $submenu->nombre }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <!-- Enlace directo si no tiene submenús -->
                        <li class="nav-item">
                            <a class="nav-link" href="#">{{ $seccion->nombre }}</a>
                        </li>
                    @endif
                @endforeach

                <!-- Enlace fijo a Videoteca -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('public.videoteca') }}">Videoteca</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
