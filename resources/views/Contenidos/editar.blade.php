@extends('base.layout')

@section('contenido')
<div class="container mt-5">
    <h2 class="mb-4 text-center">Editar Contenido</h2>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <form action="/contenidos/{{ $contenido->id }}/actualizar" method="POST" enctype="multipart/form-data">
        @csrf
      @method ('PUT')

        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" value="{{ old('titulo', $contenido->titulo) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" rows="3">{{ old('descripcion', $contenido->descripcion) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Archivo ID (por ahora manual)</label>
            <input type="number" name="archivo_id" class="form-control" value="{{ old('archivo_id', $contenido->archivo_id) }}">
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary px-4">Actualizar Contenido</button>
        </div>
    </form>
</div>
@endsection
