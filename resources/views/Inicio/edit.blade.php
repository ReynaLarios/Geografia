@extends('base.layout')

@section('contenido')
<div class="container mt-4">
    <h3>Editar Noticia</h3>

    <form action="{{ route('inicio.update', $noticia->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" name="titulo" id="titulo" class="form-control" value="{{ $noticia->titulo }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="4" required>{{ $noticia->descripcion }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Guardar cambios</button>
        <a href="{{ route('inicio.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
