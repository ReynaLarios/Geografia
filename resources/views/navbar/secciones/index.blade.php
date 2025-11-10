@extends('base.layout')

@section('contenido')
<div class="container py-4">

    <h2 class="text-center mb-4">Gestión del Menú de Navegación</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('navbar.secciones.crear') }}" class="btn btn-primary mb-3">+ Crear Sección</a>

    <div class="list-group">
        @foreach($navbarSecciones as $seccion)
            <div class="list-group-item mb-3 shadow-sm rounded">

                <div class="d-flex justify-content-between align-items-center">
                    <strong>{{ $seccion->nombre }}</strong>

                    <div>
                        <a href="{{ route('navbar.secciones.editar', $seccion->id) }}" class="btn btn-sm btn-primary">Editar</a>

                        <form action="{{ route('navbar.secciones.borrar', $seccion->id) }}"
                              method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Eliminar</button>
                        </form>

                        <a href="{{ route('navbar.contenidos.crear', $seccion->id) }}"
                           class="btn btn-sm btn-secondary">
                            + Submenú
                        </a>
                    </div>
                </div>

                {{-- SUBMENÚS --}}
                @if($seccion->contenidosNavbar->count())
                    <ul class="list-group list-group-flush mt-3 ms-3">
                        @foreach($seccion->contenidosNavbar as $hijo)
                            <li class="list-group-item d-flex justify-content-between align-items-center">

                                <div>
                                    📁 {{ $hijo->titulo }}

                                    @if($hijo->ruta)
                                        <a href="{{ $hijo->ruta }}" target="_blank" class="text-muted ms-2">
                                            <small>({{ $hijo->ruta }})</small>
                                        </a>
                                    @endif
                                </div>

                                <div>
                                    <a href="{{ route('navbar.contenidos.editar', $hijo->id) }}" class="btn btn-sm btn-primary">Editar</a>

                                    <form action="{{ route('navbar.contenidos.borrar', $hijo->id) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Eliminar</button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted ms-3 mt-2"><em>Sin submenús</em></p>
                @endif

            </div>
        @endforeach
    </div>

</div>
@endsection
