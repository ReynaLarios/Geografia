@extends('base.layout')

@section('contenido')
<h2>Agregar Submenú</h2>
<form action="{{ route('navbar-contenidos.guardar') }}" method="POST">
    @csrf
    <input type="hidden" name="navbar_seccion_id" value="{{ $seccion_id }}">
    <div class="mb-3">
        <label for="titulo" class="form-label">Título</label>
        <input type="text" name="titulo" id="titulo" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="ruta" class="form-label">Ruta / URL</label>
        <input type="text" name="ruta" id="ruta" class="form-control">
    </div>
    <button class="btn btn-success">Guardar</button>
</form>
@endsection
