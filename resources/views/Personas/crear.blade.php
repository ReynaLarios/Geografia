@extends('base.layout')

@section('contenido')
<div class="container mt-5">

    <a href="{{ route('personas.index') }}" class="btn btn-secondary mb-4">← Volver al listado</a>

    <div class="card mx-auto p-4" style="max-width: 600px; background-color: #e3f2fd; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
        <h2 class="mb-4 text-center">Crear Nueva Persona</h2>

        <form action="{{ route('personas.guardar') }}" method="POST" enctype="multipart/form-data">
            @csrf

           
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" required>
                @error('nombre')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            
            <div class="mb-3">
                <label for="datos_personales" class="form-label">Datos Personales</label>
                <textarea name="datos_personales" id="datos_personales" class="form-control" rows="4">{{ old('datos_personales') }}</textarea>
                @error('datos_personales')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

        
            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" name="foto" id="foto" class="form-control">
                @error('foto')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-success me-2">Guardar</button>
                <a href="{{ route('personas.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
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