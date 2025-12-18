@extends('public.layout')

@section('contenido')
<div class="container mt-4">
  <div class="card shadow p-3">

    @if($inicio->imagen)
      <div class="text-center mb-3">
        <img src="{{ asset('storage/'.$inicio->imagen) }}" 
     alt="{{ $inicio->titulo }}" 
     class="img-fluid rounded">

      </div>
    @endif

    <div class="card-body">
      <h3 class="card-title">{{ $inicio->titulo }}</h3>
      <p class="text-muted" style="font-size: 14px;">
        Publicado el {{ $inicio->created_at->format('d/m/Y') }}
      </p>
      <div class="mt-3">
        {!! $inicio->descripcion !!}
      </div>
      @if($inicio->archivos->count())
        <h5 class="mt-4">Archivos adjuntos:</h5>
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

      <a href="{{ route('public.inicio.index') }}" class="btn btn-secondary mt-3">Volver</a>
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
