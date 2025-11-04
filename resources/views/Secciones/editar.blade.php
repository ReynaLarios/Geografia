@extends('base.layout')

@section('contenido')
<div class="container mt-4">
    <h2 class="mb-3">Editar Sección</h2>

    <form action="{{ route('secciones.actualizar', $seccion->id) }}" method="POST">
    @csrf
    @method('PUT')

        <div class="mb-3">
            <label class="form-label"><strong>Nombre:</strong></label>
            <input 
                type="text" 
                name="nombre" 
                class="form-control" 
                value="{{ old('nombre', $seccion->nombre) }}" 
                required>
        </div>
<textarea name="descripcion" id="descripcion" class="form-control" rows="10">
    {!! old('descripcion', $seccion->descripcion ?? '') !!}
</textarea>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('secciones.listado') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
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
@endsection
