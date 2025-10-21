@extends('base.layout')

@section('contenido')
<h2>{{ $seccion->nombre }}</h2>
<p>{{ $seccion->descripcion }}</p>
<hr>
<h4>Contenidos de esta sección</h4>
<ul>
    @foreach($seccion->contenidos as $contenido)
        <li>
            <a href="{{ route('contenidos.{id}.mostrar', $contenido->id) }}" class="fancy">
                {{ $contenido->titulo }}
            </a>
        </li>
    @endforeach
</ul>
@endsection
