@extends('base.layout')

@section('contenido')
<div class="container mt-4">
    <h2 class="mb-3"><strong>Agregar Nuevo Cuadro</strong></h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('cuadros.guardar') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" name="titulo" id="titulo" class="form-control" placeholder="Título del cuadro" required>
        </div>

        <div class="mb-3">
            <label for="autor" class="form-label">Autor</label>
            <input type="text" name="autor" id="autor" class="form-control" placeholder="Nombre del autor">
        </div>

        <div class="mb-3">
            <label for="enlace" class="form-label">Enlace</label>
            <input type="url" name="enlace" id="enlace" class="form-control" placeholder="https://...">
        </div>

        <button type="submit" class="btn btn-primary">Agregar Cuadro</button>
        <a href="{{ route('cuadros.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
