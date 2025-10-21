@extends('base.layout')

@section('contenido')
<div class="container">
    <h2 class="mb-3">Agregar Nueva Sección</h2>
    <form action="{{ route('secciones.guardar') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nombre:</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Descripción:</label>
            <textarea name="descripcion" class="form-control" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('secciones.listar') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
