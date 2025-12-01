@extends('base.layout')

@section('contenido')
<div class="container mt-4">
    <h2>Editar Persona</h2>
    <form action="{{ route('personas.actualizar', $persona->slug) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $persona->nombre) }}">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $persona->email) }}">
        </div>

        <div class="mb-3">
            <label>Datos Personales</label>
            <textarea name="datos_personales" id="datos_personales" class="form-control">{{ old('datos_personales', $persona->datos_personales) }}</textarea>
        </div>

        <div class="mb-3">
            <label>Foto</label>
            <input type="file" name="foto" class="form-control">
            @if($persona->foto)
                <img src="{{ asset('storage/' . $persona->foto) }}" width="100" class="mt-2">
            @endif
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('personas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection

@section('scripts')
<!-- CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#datos_personales'))
        .catch(error => {
            console.error(error);
        });
</script>
@endsection

