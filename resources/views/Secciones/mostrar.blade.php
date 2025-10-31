@extends('base.layout')

@section('contenido')
<div class="container mt-4">

    <h2 class="mb-3"><strong>{{ $seccion->nombre }}</strong></h2>

    {{-- Descripción con formato HTML (negritas, links, listas, etc.) --}}
    <div class="seccion-descripcion">
        {!! $seccion->descripcion !!}
    </div>

    {{-- Contenidos relacionados --}}
    @if($seccion->contenidos->count() > 0)
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
<style>
.seccion-descripcion p {
  margin-bottom: 1rem;
}

.seccion-descripcion a {
  color: #007bff; 
  text-decoration: underline;
  cursor: pointer;
}

.seccion-descripcion a:hover {
  color: #0056b3;
  text-decoration: none;
}
</style>

@endsection
