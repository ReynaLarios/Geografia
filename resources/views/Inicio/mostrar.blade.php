@extends('base.layout')

@section('contenido')
<div class="container mt-4">
  <div class="card shadow">
    @if($noticia->imagen)
      <img src="{{ asset('storage/'.$noticia->imagen) }}" class="card-img-top" alt="{{ $noticia->titulo }}">
    @endif
    <div class="card-body">
      <h3>{{ $noticia->titulo }}</h3>
      <p>{{ $noticia->descripcion }}</p>
      <a href="{{ route('inicio.index') }}" class="btn btn-secondary">Volver</a>
    </div>
  </div>
</div>
@endsection
