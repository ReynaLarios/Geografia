@extends('public.layout_public')

@section('contenido')
<div class="container">
    <h2 class="fw-bold text-primary mb-4">{{ $seccion->nombre }}</h2>

    @if($seccion->descripcion)
        <div class="mb-4">
            {!! $seccion->descripcion !!}
        </div>
    @endif

    @if($seccion->contenidosNavbar && $seccion->contenidosNavbar->count())
        <div class="row g-4">
            @foreach($seccion->contenidosNavbar as $contenido)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0" style="border-radius: 15px;">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">{{ $contenido->nombre }}</h5>
                        <p class="card-text text-muted">
                            {{ Str::limit(strip_tags($contenido->descripcion ?? 'Sin descripción'), 100) }}
                        </p>
                        <a href="{{ route('public.verContenido', $contenido->id) }}" class="btn btn-outline-primary mt-2">Ver contenido</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <p class="text-muted fst-italic">No hay contenidos disponibles en esta sección.</p>
    @endif
</div>
@endsection
