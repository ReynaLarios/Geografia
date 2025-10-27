@extends('base.layout')

@section('contenido')
<div class="container mt-4">
    <h2 class="mb-3"><strong>{{ $seccion->nombre }}</strong></h2>

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="mb-2"><strong>Descripción:</strong></h5>
            <!-- Aquí se muestra el contenido con formato HTML -->
            <div>{!! $seccion->descripcion !!}</div>
        </div>
    </div>

    <!-- Si quieres mostrar otros contenidos relacionados -->
    @if($seccion->contenidos->count() > 0)
        <div class="card">
            <div class="card-body">
                <h5><strong>Contenidos relacionados:</strong></h5>
                <ul>
                    @foreach($seccion->contenidos as $contenido)
                        <li>
                            <strong>{{ $contenido->titulo }}</strong> - {!! $contenido->descripcion !!}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
</div>
@endsection
