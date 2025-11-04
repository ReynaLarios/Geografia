@extends('base.layout')

@section('contenido')
<h2>Editar Contenido</h2>
<form action="{{ route('contenidos.actualizar', $contenido->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="titulo" class="form-label">Título</label>
        <input type="text" name="titulo" id="titulo" class="form-control" value="{{ $contenido->titulo }}" required>
    </div>
    <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea name="descripcion" id="descripcion" class="form-control">{{ $contenido->descripcion }}</textarea>
    </div>
    <button type="submit" class="btn btn-primary">Actualizar</button>
</form>
@endsection
