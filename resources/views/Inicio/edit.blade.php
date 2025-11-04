@extends('base.layout')

@section('contenido')
<div class="container mt-4">
  <h3>Editar Noticia</h3>

  <form action="{{ route('inicio.update', $inicio->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
      <label for="titulo" class="form-label">Título</label>
      <input type="text" name="titulo" id="titulo" class="form-control" value="{{ $inicio->titulo }}" required>
    </div>

    <div class="mb-3">
      <label for="descripcion" class="form-label">Descripción</label>
      <textarea name="descripcion" id="descripcion" class="form-control" rows="4" required>{{ $inicio->descripcion }}</textarea>
    </div>

    <div class="mb-3">
      <label for="imagen" class="form-label">Imagen (opcional)</label>
      @if($inicio->imagen)
        <div class="mb-2">
          <img src="{{ asset('storage/'.$noticia->imagen) }}" width="150" class="rounded" alt="imagen actual">
        </div>
      @endif
      <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*">
    </div>

    <button type="submit" class="btn btn-primary">Guardar cambios</button>
    <a href="{{ route('inicio.index') }}" class="btn btn-secondary">Cancelar</a>
  </form>
</div>
@endsection
