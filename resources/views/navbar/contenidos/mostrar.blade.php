@extends('base.layout')

@section('contenido')
<div class="container mt-4">

    <h2 class="mb-3">{{ $contenido->titulo }}</h2>

    <p><strong>Sección:</strong> {{ $contenido->seccion->nombre }}</p>

    @if($contenido->imagen)
        <img src="{{ asset('storage/' . $contenido->imagen) }}" class="img-fluid mb-3" style="max-width:300px;">
    @endif

    <div class="mt-3">
        {!! $contenido->descripcion !!}
    </div>

    <a href="{{ route('navbar.contenidos.index') }}" class="btn btn-secondary mt-3">Regresar</a>

</div>
@endsection
