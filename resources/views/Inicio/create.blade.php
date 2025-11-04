@extends('base.layout')

@section('contenido')
<div class="container mt-4">
  <h3>Nueva Noticia</h3>

  <form action="{{ route('inicio.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
      <label for="titulo" class="form-label">Título</label>
      <input type="text" name="titulo" id="titulo" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="descripcion" class="form-label">Descripción</label>
      <textarea name="descripcion" id="descripcion" class="form-control" rows="4" required></textarea>
    </div>

    <div class="mb-3">
      <label for="imagen" class="form-label">Imagen</label>
      <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*">
    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('inicio.index') }}" class="btn btn-secondary">Cancelar</a>
  </form>
</div>
@endsection
