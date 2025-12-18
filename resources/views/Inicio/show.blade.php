@extends('base.layout')

@section('contenido')
<div class="container mt-4">
  <div class="card shadow">

    @if($inicio->imagen)
     <img 
        src="{{ asset('storage/'.$inicio->imagen) }}" 
        class="card-img-top"
        alt="{{ $inicio->titulo }}"
        style="width: 100%; max-width: 500px; height: auto; margin: 20px auto; display: block; border-radius: 10px;">

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

