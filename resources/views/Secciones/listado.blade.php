@extends('base.layout')

@section('contenido')
<main class="container mt-4">

    <h2 class="mb-4 text-center">Listado de Secciones</h2>

    @if($secciones && $secciones->count() > 0)
        <div class="row g-4">
            @foreach($secciones as $seccion)
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $seccion->nombre }}</h5>

                            @if($seccion->descripcion)
                                <p class="card-text text-truncate">{{ $seccion->descripcion }}</p>
                            @endif

                            {{-- Cuadros de la sección --}}
                            @if($seccion->cuadros && $seccion->cuadros->count() > 0)
                                <p class="mb-2"><strong>Cuadros:</strong> {{ $seccion->cuadros->count() }}</p>
                            @endif

                            {{-- Botones --}}
                            <div class="mt-auto d-flex justify-content-between">
                                <a href="{{ route('secciones.mostrar', $seccion->id) }}" class="btn btn-info btn-sm">Ver</a>
                                <a href="{{ route('secciones.editar', $seccion->id) }}" class="btn btn-warning btn-sm">Editar</a>

                                <form action="{{ route('secciones.borrar', $seccion->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar sección?')">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-center text-muted">No hay secciones registradas.</p>
    @endif

</main>
@endsection
