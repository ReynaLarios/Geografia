@extends('base.layout')

@section('contenido')
<div class="container mt-4">
    <h2 class="mb-4 text-center">Editar Contenido</h2>

    <form action="{{ route('navbar.contenidos.actualizar', $contenido->id) }}" method="POST" enctype="multipart/form-data" class="p-4 bg-light rounded shadow-sm">
       @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" value="{{ old('titulo', $contenido->titulo) }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="ckeditor" class="form-control" rows="5">{{ old('descripcion', $contenido->descripcion) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen</label>
            @if($contenido->imagen)
                <div class="mb-2">
                    <img src="{{ asset($contenido->imagen) }}" alt="Imagen actual" width="200" class="rounded shadow-sm">
                </div>
            @endif
            <input type="file" name="imagen" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary w-100">Actualizar Contenido</button>
    </form>
</div>

{{-- CKEditor --}}
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('ckeditor');
</script>
@endsection
