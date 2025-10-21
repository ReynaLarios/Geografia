@extends('base.layout')

@section('contenido')
<div class="container">
    <h2 class="mb-3">Editar Sección</h2>
    <form action="{{ route('secciones.update', $seccion->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Nombre:</label>
            <input type="text" name="nombre" class="form-control" value="{{ $seccion->nombre }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Descripción:</label>
            <textarea name="descripcion" class="form-control" rows="4" required>{{ $seccion->descripcion }}</textarea>
        </div>
        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('secciones.listar') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
