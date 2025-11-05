@extends('base.layout')

@section('contenido')
<div class="container py-4">
  <h2 class="mb-4">Editar Submenú</h2>

  <form action="{{ route('navbar-contenidos.actualizar', $contenido->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre del Submenú</label>
      <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $contenido->nombre }}" required>
    </div>

    <div class="mb-3">
      <label for="ruta" class="form-label">Ruta o URL</label>
      <input type="text" name="ruta" id="ruta" class="form-control" value="{{ $contenido->ruta }}" required>
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="{{ route('navbar.secciones.index') }}" class="btn btn-secondary">Cancelar</a>
  </form>
</div>
@endsection
