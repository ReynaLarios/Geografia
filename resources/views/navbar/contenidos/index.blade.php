@extends('base.layout')

@section('contenido')
<div class="container py-4">
    <h2 class="text-center mb-4">Gestión del Menú de Navegación</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

   <a href="{{ route('navbar.contenidos.crear', $sec->id) }}" class="btn btn-info btn-sm">+ Submenú</a>


    <div class="list-group">
        @forelse($navbarSecciones as $seccion)
            <div class="list-group-item mb-3 shadow-sm rounded">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $seccion->nombre }}</strong>
                        @if($seccion->ruta)
                            <a href="{{ $seccion->ruta }}" target="_blank" class="text-muted ms-2">
                                <small>({{ $seccion->ruta }})</small>
                            </a>
                        @endif
                    </div>

                    <div>
                        <a href="{{ route('navbar.secciones.editar', $seccion->id) }}" class="btn btn-sm btn-primary">Editar</a>
                        <form action="{{ route('navbar.secciones.borrar', $seccion->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta sección?')">Eliminar</button>
                        </form>
                        <a href="{{ route('navbar.contenidos.crear', $seccion->id) }}" class="btn btn-sm btn-secondary">Agregar Submenú</a>
                    </div>
                </div>
@if($seccion->contenidosNavbar->count())
    <ul class="list-group list-group-flush mt-3 ms-3">
        @foreach($seccion->contenidosNavbar as $hijo)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <span> {{ $hijo->nombre }}</span>
                    @if($hijo->ruta)
                        <a href="{{ $hijo->ruta }}" target="_blank" class="text-muted ms-2">
                            <small>({{ $hijo->ruta }})</small>
                        </a>
                    @endif
                </div>

                <div>
                    <a href="{{ route('navbar.contenidos.editar', $hijo->id) }}" class="btn btn-sm btn-primary">Editar</a>
                    <form action="{{ route('navbar.contenidos.borrar', $hijo->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este submenú?')">Eliminar</button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
@else
    <p class="text-muted mt-2 ms-3"><em>Sin submenús</em></p>
@endif

            </div>
        @empty
            <p class="text-center text-muted">No hay secciones registradas aún.</p>
        @endforelse
    </div>
</div>
@endsection
