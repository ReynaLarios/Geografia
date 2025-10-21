@extends('base.layout')

@section('contenido')
<h2>{{ $contenido->titulo }}</h2>
<p>{{ $contenido->descripcion }}</p>

<a href="{{ route('secciones.{id}.mostrar', $seccion->id) }}" class="fancy">← Volver a la sección</a>
@endsection
