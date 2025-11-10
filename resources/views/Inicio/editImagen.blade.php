@extends('base.layout')

@section('contenido')
<div class="container mt-4">
    <h3>Editar Imagen del Carrusel</h3>

    <form action="{{ route('inicio.updateImagen', $imagen->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen Actual</label><br>
            <img src="{{ asset('storage/'.$imagen->imagen) }}" width="200" class="rounded mb-3" alt="Imagen actual">
        </div>

        <div class="mb-3">
            <label for="imagen" class="form-label">Cambiar Imagen</label>
            <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*">
            <small class="text-muted">Si no seleccionas nada, la imagen actual se mantiene.</small>
        </div>

        <button type="submit" class="btn btn-primary">Guardar cambios</button>
        <a href="{{ route('inicio.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
