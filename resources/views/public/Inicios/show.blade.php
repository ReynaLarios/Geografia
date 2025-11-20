@extends('public.layout')

@section('contenido')
<div class="container mt-4">
  <div class="card shadow p-3">

    {{-- Imagen de la noticia centrada --}}
    @if($inicio->imagen)
      <div class="text-center mb-3">
        <img src="{{ asset('storage/'.$inicio->imagen) }}" 
             alt="{{ $inicio->titulo }}" 
             class="img-fluid rounded" 
             style="max-width:500px;">
      </div>
    @endif

    <div class="card-body">
      <h3 class="card-title">{{ $inicio->titulo }}</h3>
      
      {{-- Descripción limpia, sin HTML del editor --}}
      <p>{{ strip_tags($inicio->descripcion) }}</p>

      {{-- Archivos adjuntos --}}
      @if($inicio->archivos->count())
        <h5>Archivos adjuntos:</h5>
        <ul>
          @foreach($inicio->archivos as $archivo)
            <li>
              <a href="{{ asset('storage/'.$archivo->archivo) }}" target="_blank">
                {{ $archivo->nombre_real }}
              </a>
            </li>
          @endforeach
        </ul>
      @endif

      <a href="{{ route('inicio.index') }}" class="btn btn-secondary mt-3">Volver</a>
    </div>
  </div>
</div>

<style>
.btn-secondary {
    background-color: #A0C4FF;
    border-color: #A0C4FF;
    color: #03045e;
}
</style>
@endsection
