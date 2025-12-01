@extends('base.layout')

@section('contenido')
<div class="container mt-4">
    <h3>Editar Noticia</h3>

    <form action="{{ route('inicio.update', $noticia->slug) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" name="titulo" id="titulo" class="form-control" value="{{ $noticia->titulo }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="4">{{ $noticia->descripcion }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Imagen principal</label>
            @if($noticia->imagen)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $noticia->imagen) }}" alt="Imagen" style="max-width:200px;">
                </div>
            @endif
            <input type="file" name="imagen" class="form-control">
        </div>


        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('inicio.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor.create(document.querySelector('#descripcion'));
</script>
@endsection
