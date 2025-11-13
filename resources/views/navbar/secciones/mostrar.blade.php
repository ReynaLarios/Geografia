@extends('base.layout')

@section('contenido')
<div class="container mt-4">
    <h2 class="mb-4 text-center" style="color: var(--azul-oscuro);">
        <strong>{{ $seccion->nombre }}</strong>
    </h2>

    @if($seccion->contenidosNavbar && $seccion->contenidosNavbar->count())
        <div class="row">
            @foreach($seccion->contenidosNavbar as $contenido)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="p-3 rounded shadow-sm" style="background: var(--azul-suave); color: var(--azul-oscuro); border-left: 5px solid var(--azul-medio);">
                        <h5 class="fw-bold mb-2">{{ $contenido->nombre }}</h5>
                        <a href="{{ route('navbar.contenidos.mostrar', $contenido->id) }}" class="btn btn-sm" style="background-color: var(--azul-medio); color: var(--blanco); border-radius: 20px;">
                            Ver contenido
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-center text-muted">Esta sección no tiene contenidos aún.</p>
    @endif

    <div class="mt-3">
        <button class="fancy" onclick="window.history.back()">← Regresar</button>
    </div>
</div>
@endsection
