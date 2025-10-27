@extends('base.layout')

@section('contenido')
<div class="container mt-4">
  <div id="carouselNoticias" class="carousel slide mb-6" data-bs-ride="carousel">
    <div class="carousel-inner text-center">
      <div class="carousel-item active">
        <img src="{{ asset('geDones en geografía.png') }}" class="d-block mx-auto carousel-img" alt="Imagen 1">
      </div>
      <div class="carousel-item">
        <img src="{{ asset('geo.jpg') }}" class="d-block mx-auto.carousel-img" alt="Imagen 2">
      </div>
      <div class="carousel-item">
        <img src="{{ asset('geo.jpg') }}" class="d-block mx-auto carousel-img" alt="Imagen 3">
      </div>
    </div>
  </div>

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Noticias</h2>
    <a href="{{ route('dashboard') }}" class="btn btn-success">➕ Nueva Noticia</a>
  </div>

  @if(session('success'))
    <div class="alert alert-success text-center">{{ session('success') }}</div>
  @endif

  <ul class="list-group">
    @foreach($inicio as $in)
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
          @if($in->imagen)
            <img src="{{ asset('storage/'.$in->imagen) }}" width="70" height="70" class="rounded me-3" alt="imagen">
          @endif
          <div>
            <strong>{{ $in->titulo }}</strong><br>
            <small>{{ \Illuminate\Support\Str::limit($in->descripcion, 80) }}</small>
          </div>
        </div>
        <div>
          <a href="{{ route('dashboard', $in->id) }}" class="btn btn-sm btn-info">Ver</a>
          <a href="{{ route('dashboard', $in->id) }}" class="btn btn-sm btn-warning">Editar</a>
          <form action="{{ route('dashboard', $in->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar noticia?')">Borrar</button>
          </form>
        </div>
      </li>
    @endforeach
  </ul>
</div>
@endsection
