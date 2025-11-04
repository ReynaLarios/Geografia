@extends('base.layout')

@section('contenido')
<div class="container mt-4">

    <h2 class="mb-3"><strong>{{ $seccion->nombre }}</strong></h2>

    <div class="seccion-descripcion">
        {!! $seccion->descripcion !!}
    </div>

    @if($seccion->contenidos->isNotEmpty())
        <div class="card mt-4 shadow-sm">
            <div class="card-body">
                <h5><strong>Contenidos relacionados:</strong></h5>
                <ul class="list-unstyled">
                    @foreach($seccion->contenidos as $contenido)
                        <li class="mb-3">
                            <strong>{{ $contenido->titulo }}</strong><br>
                            <div class="contenido-descripcion">
                                {!! $contenido->descripcion !!}
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

</div>
@endsection
