@extends('base.layout')

@section('contenido')
<div class="container mt-4">
    <h2 class="mb-3"><strong>Editar Cuadro</strong></h2>

    <form action="{{ route('cuadros.actualizar', $cuadro->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" value="{{ $cuadro->titulo }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Autor</label>
            <input type="text" name="autor" class="form-control" value="{{ $cuadro->autor }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Enlace (URL)</label>
            <input type="url" name="enlace" class="form-control" value="{{ $cuadro->enlace }}" required>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" name="mostrar" id="mostrar" {{ $cuadro->mostrar ? 'checked' : '' }}>
            <label class="form-check-label" for="mostrar">Mostrar en la vista</label>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Cuadro</button>
        <a href="{{ route('cuadros.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
