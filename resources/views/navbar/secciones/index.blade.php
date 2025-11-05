@extends('base.layout')

@section('contenido')
<main class="p-4" style="background-color: #fff; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
    <h2 class="text-center mb-4">Secciones del Navbar</h2>

    <nav class="navbar navbar-expand-lg navbar-light bg-light rounded shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Mi Sitio</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    @foreach ($navbarSecciones as $seccion)
                        @if ($seccion->hijos->count() > 0)
                            <!-- Dropdown para secciones con hijos -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown{{ $seccion->id }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ $seccion->nombre }}
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown{{ $seccion->id }}">
                                    @foreach ($seccion->hijos as $hijo)
                                        <li><a class="dropdown-item" href="#">{{ $hijo->nombre }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <!-- Sección sin hijos -->
                            <li class="nav-item">
                                <a class="nav-link" href="#">{{ $seccion->nombre }}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </nav>
</main>
@endsection
