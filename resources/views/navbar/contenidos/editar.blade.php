@extends('base.layout')

@section('contenido')
<div class="container py-4">
    <h2>Editar Submenú "{{ $navbar_contenido->titulo }}"</h2>

    <form action="{{ route('navbar.contenidos.actualizar', $navbar_contenido->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" name="titulo" id="titulo" class="form-control" value="{{ $navbar_contenido->titulo }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="3">{{ $navbar_contenido->descripcion }}</textarea>
        </div>

        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen (opcional)</label>
            <input type="file" name="imagen" id="imagen" class="form-control">
            @if($navbar_contenido->imagen)
                <img src="{{ asset('storage/' . $navbar_contenido->imagen) }}" style="width:80px; height:auto;" class="mt-2">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Submenú</button>
    </form>
</div>
@endsection
