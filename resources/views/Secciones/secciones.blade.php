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
        <div class="mb-3">
            <label class="form-label"><strong>Descripción:</strong></label>
  
            <textarea name="descripcion" id="descripcion" class="form-control" rows="6" required></textarea>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('secciones.listado') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
@section('scripts')
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('descripcion', {
        height: 250,
        removeButtons: '', 
        toolbar: [
            { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike' ] },
            { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent' ] },
            { name: 'links', items: [ 'Link', 'Unlink' ] },
            { name: 'clipboard', items: [ 'Undo', 'Redo' ] },
            { name: 'styles', items: [ 'Format', 'Font', 'FontSize' ] },
            { name: 'colors', items: [ 'TextColor', 'BGColor' ] }
        ]
    });
</script>
@endsection
