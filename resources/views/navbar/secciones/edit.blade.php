@extends('base.layout')

@section('contenido')
<h2>Editar Sección</h2>
<form action="{{ route('secciones.actualizar', $seccion->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre de la sección</label>
        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $seccion->nombre }}" required>
    </div>
    <button type="submit" class="btn btn-primary">Actualizar</button>
</form>
@endsection
