@extends('base.layout')

@section('contenido')
<div class="container mt-5">
  <h2>Editar video</h2>
  <form action="{{ route('videoteca.update', $video->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
      <label>Título</label>
      <input type="text" name="titulo" class="form-control" value="{{ $video->titulo }}" required>
    </div>
    <div class="mb-3">
      <label>URL de YouTube</label>
      <input type="url" name="url" class="form-control" value="{{ $video->url }}" required>
    </div>
    <div class="mb-3">
      <label>Categoría</label>
      <input type="text" name="categoria" class="form-control" value="{{ $video->categoria }}">
    </div>
    <div class="mb-3">
      <label>Año</label>
      <input type="text" name="anio" class="form-control" value="{{ $video->anio }}">
    </div>
    <div class="mb-3">
      <label>Descripción</label>
      <textarea name="descripcion" class="form-control">{{ $video->descripcion }}</textarea>
    </div>
    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="{{ route('videoteca.index') }}" class="btn btn-secondary">Cancelar</a>
  </form>
</div>
@endsection
