@extends('base.layout')

@section('contenido')
<div class="container mt-5">
  <h2 class="mb-4 text-center text-primary">{{ $video->titulo }}</h2>
  <div class="ratio ratio-16x9 mb-4">
    <iframe src="{{ $video->url }}" allowfullscreen></iframe>
  </div>
  <p><strong>Categoría:</strong> {{ $video->categoria ?? 'Sin categoría' }}</p>
  <p><strong>Año:</strong> {{ $video->anio ?? 'N/A' }}</p>
  <p>{{ $video->descripcion }}</p>
  <a href="{{ route('videoteca.index') }}" class="btn btn-outline-secondary">Volver</a>
</div>
@endsection
