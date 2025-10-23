@extends('base.layout')

@section('contenido')
<div class="container mt-5">
  <h2 class="mb-4 text-center">Videoteca</h2>
  <p class="text-center">Selecciona una sección para ver los videos:</p>

  <div class="row justify-content-center">

    <!-- Sección Recientes -->
    <div class="col-md-5 mb-4">
      <a href="{{ url('/videoteca/recientes') }}" class="text-decoration-none">
        <div class="card shadow-lg border-0">
          <!-- Fondo de la tarjeta -->
          <div class="card-img-top bg-dark"
               style="background: url('https://www.youtube.com/embed/6tyoh1321PU') center/cover;
                      height: 200px; border-top-left-radius: .5rem; border-top-right-radius: .5rem;">
          </div>
          <div class="card-body text-center">
            <h4 class="text-black">Seminario de investigación</h4>
            <p class="text-muted"></p>
          </div>
        </div>
      </a>
    </div>

    <!-- Sección Populares -->
    <div class="col-md-5 mb-4">
      <a href="{{ url('/videoteca/populares') }}" class="text-decoration-none">
        <div class="card shadow-lg border-0">
          <!-- Fondo de la tarjeta -->
          <div class="card-img-top bg-dark"
               style="background: url('https://www.youtube.com/embed/6tyoh1321PU') center/cover;
                      height: 200px; border-top-left-radius: .5rem; border-top-right-radius: .5rem;">
          </div>
          <div class="card-body text-center">
            <h4 class="text-black">Varios</h4>
            <p class="text-muted"></p>
          </div>
        </div>
      </a>
    </div>

  </div>
</div>
@endsection



@extends('base.layout')

@section('contenido')
<div class="container mt-5">
  <h2 class="mb-4 text-center">Videoteca</h2>
  
  @if(session('success'))
    <div class="alert alert-success text-center">{{ session('success') }}</div>
  @endif

  <div class="text-end mb-4">
    <a href="{{ route('videoteca.create') }}" class="btn btn-success">+ Agregar video</a>
  </div>

  <div class="row justify-content-center">
    @forelse ($videos as $video)
      @php
        // Extrae el ID del video (última parte del enlace embed)
        preg_match('/embed\/([^\?]+)/', $video->url, $matches);
        $videoId = $matches[1] ?? null;
        $thumbnail = $videoId ? "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg" : null;
      @endphp

      <div class="col-md-4 col-sm-6 mb-4">
        <div class="card shadow-lg border-0 h-100">
          @if($thumbnail)
            <a href="{{ route('videoteca.show', $video->id) }}">
              <img src="{{ $thumbnail }}" class="card-img-top" alt="{{ $video->titulo }}">
            </a>
          @endif
          <div class="card-body text-center">
            <h5 class="card-title">{{ $video->titulo }}</h5>
            @if($video->anio)
              <p class="text-muted mb-2">{{ $video->anio }}</p>
            @endif
            <a href="{{ route('videoteca.show', $video->id) }}" class="btn btn-outline-primary btn-sm">Ver</a>
            <a href="{{ route('videoteca.edit', $video->id) }}" class="btn btn-outline-warning btn-sm">Editar</a>
            <form action="{{ route('videoteca.destroy', $video->id) }}" method="POST" class="d-inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Eliminar este video?')">
                Eliminar
              </button>
            </form>
          </div>
        </div>
      </div>
    @empty
      <p class="text-center">No hay videos en la videoteca aún 😢</p>
    @endforelse
  </div>
</div>
@endsection
