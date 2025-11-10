@extends('base.layout')

@section('contenido')
<div class="container mt-4">
    <h3>Subir Nueva Imagen</h3>

    <form action="{{ route('inicio.storeImagen') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen</label>
            <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*" required>
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('inicio.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
