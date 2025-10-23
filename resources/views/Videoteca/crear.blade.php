@extends('base.layout')

@section('contenido')
<div class="container mt-5">
  <h2>Agregar nuevo video</h2>
  <form action="{{ route('videoteca.store') }}" method="POST">
    @csrf
    <div class="mb-3">
      <label>Título</label>
      <input type="text" name="titulo" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>URL de YouTube</label>
      <input type="url" name="url" class="form-control" placeholder="https://www.youtube.com/embed/..." required>
    </div>
    <div class="mb-3">
      <label>Categoría</label>
      <input type="text" name="categoria" class="form-control">
    </div>
    <div class="mb-3">
      <label>Año</label>
      <input type="text" name="anio" class="form-control">
    </div>
    <div class="mb-3">
      <label>Descripción</label>
      <textarea name="descripcion" class="form-control"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('videoteca.index') }}" class="btn btn-secondary">Cancelar</a>
  </form>
</div>
@endsection
