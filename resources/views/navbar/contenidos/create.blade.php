@extends('base.layout')

@section('contenido')
<div class="container py-4">
  <h2 class="mb-4">Agregar Submenú a: <strong>{{ $seccion->nombre }}</strong></h2>

  <form action="{{ route('navbar-contenidos.guardar', $seccion->id) }}" method="POST">
    @csrf

    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre del Submenú</label>
      <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ej. Contacto" required>
    </div>

    <div class="mb-3">
      <label for="ruta" class="form-label">Ruta o URL</label>
      <input type="text" name="ruta" id="ruta" class="form-control" placeholder="/contacto o https://ejemplo.com" required>
      <small class="text-muted">Pon aquí la URL o la ruta interna del sitio.</small>
    </div>

    <button type="submit" class="btn btn-success">Guardar Submenú</button>
    <a href="{{ route('navbar.secciones.index') }}" class="btn btn-secondary">Cancelar</a>
  </form>
</div>
@endsection
