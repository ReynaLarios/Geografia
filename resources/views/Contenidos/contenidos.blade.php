@extends('base.layout')

@section('contenido')
<main>
    <h2>{{ isset($contenido) ? 'Editar Contenido' : 'Crear Contenido' }}</h2>

    <form action="{{ isset($contenido) ? route('contenidos.actualizar', $contenido->id) : route('contenidos.guardar') }}" 
          method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($contenido)) @method('PUT') @endif

        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" name="titulo" id="titulo" class="form-control" 
                   value="{{ $contenido->titulo ?? old('titulo') }}" required>
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" id="descripcion" rows="10" class="form-control">{{ old('descripcion', $contenido->descripcion ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="seccion_id" class="form-label">Sección</label>
            <select name="seccion_id" id="seccion_id" class="form-control" required>
                <option value="">Selecciona una sección</option>
                @foreach($secciones as $sec)
                    <option value="{{ $sec->id }}" {{ isset($contenido) && $contenido->seccion_id == $sec->id ? 'selected' : '' }}>
                        {{ $sec->nombre }}
                    </option>
                @endforeach
            </select>
        </div>



        <div id="archivos-container" class="mt-4">
            <h5>Archivos asociados</h5>

            @if(isset($archivos) && count($archivos) > 0)
                <table class="table table-bordered mt-3">
                    <thead class="table-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Tamaño</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($archivos as $archivo)
                            <tr>
                                <td>
                                    <a href="{{ asset('storage/'.$archivo->ruta) }}" target="_blank">
                                        📎 {{ $archivo->nombre }}
                                    </a>
                                </td>
                                <td>{{ round(Storage::disk('public')->size($archivo->ruta)/1024/1024, 2) }} MB</td>
                                <td>
                                    <form action="{{ route('archivos.borrar', $archivo->id) }}" method="POST">
                                        @csrf
                                        
                                        <span onclick=""></span>
                                        
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted">No hay archivos asociados a este contenido aún.</p>
            @endif

            <div class="mt-3">
                <label for="archivos" class="form-label">Subir nuevos archivos</label>
                <input type="file" name="archivos[]" id="archivos" class="form-control" multiple>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary mt-4">
            {{ isset($contenido) ? 'Actualizar' : 'Crear' }}
        </button>
    </form>
</main>

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
