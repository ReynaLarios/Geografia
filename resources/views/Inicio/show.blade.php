@extends('base.layout')

@section('contenido')
<div class="container mt-4">
  <div class="card shadow">
@if($inicio->imagen)
    <div class="imagen-cuadrada mx-auto my-4">
        <img 
            src="{{ asset('storage/'.$inicio->imagen) }}" 
            alt="{{ $inicio->titulo }}">
    </div>
@endif


    <div class="card-body text-center">

 
      <h3>{{ $inicio->titulo }}</h3>

      <p class="text-muted" style="font-size: 14px;">
        Publicado el {{ $inicio->created_at->format('d/m/Y') }}
      </p>

  
      <div class="text-start">
        {!! $inicio->descripcion !!}
      </div>

      <a href="{{ route('inicio.index') }}" class="btn btn-secondary mt-3">Volver</a>
    </div>
  </div>
</div>
@endsection

