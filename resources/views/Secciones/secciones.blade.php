@extends('base.layout')

@section('contenido')
<div class="container mt-4">
    <h2 class="mb-3">Agregar Nueva Sección</h2>
    <form action="{{ route('secciones.guardar') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label"><strong>Nombre:</strong></label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
       <div class="form-group">
    <label for="descripcion">Descripción</label>
    <textarea name="descripcion" id="descripcion" class="form-control" rows="10">{{ old('descripcion', $seccion->descripcion ?? '') }}</textarea>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
ClassicEditor
    .create(document.querySelector('#descripcion'), {
        toolbar: [ 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ]
    })
    .catch(error => {
        console.error(error);
    });
</script>

        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('secciones.listado') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
