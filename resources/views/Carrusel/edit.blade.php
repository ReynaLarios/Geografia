@extends('base.layout')

@section('contenido')
<div class="container mt-4">
    <h3>Editar Imagen</h3>

    <form action="{{ route('inicio.updateImagen', $imagen->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen Actual</label>
            <div class="mb-2">
                <img src="{{ asset('storage/'.$imagen->imagen) }}" width="200" class="rounded" alt="Imagen actual">
            </div>
            <label for="imagen" class="form-label">Cambiar Imagen</label>
            <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-warning">Actualizar</button>
        <a href="{{ route('inicio.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
