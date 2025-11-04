@extends('base.layout')

@section('contenido')
<div class="container mt-4">
  <div class="card shadow">
    @if($inicio->imagen)
      <img src="{{ asset('storage/'.$inicio->imagen) }}" class="card-img-top" alt="{{ $inicio->titulo }}">
    @endif
    <div class="card-body">
      <h3>{{ $inicio->titulo }}</h3>
      <p>{{ $inicio->descripcion }}</p>
      <a href="{{ route('inicio.index') }}" class="btn btn-secondary">Volver</a>
    </div>
  </div>
</div>
@endsection
