@extends('base.layout')

@section('contenido')
<main class="p-4" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
    <h2>Editar Sección</h2>

    <form action="{{ route('secciones.actualizar', $seccion->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Nombre de la sección --}}
        <div class="mb-3">
            <label class="form-label">Nombre de la sección</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $seccion->nombre) }}" required>
        </div>

        {{-- Descripción --}}
        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control">{{ old('descripcion', $seccion->descripcion) }}</textarea>
        </div>

        {{-- Video --}}
        <div class="mb-3">
            <label class="form-label">Subir Video (opcional)</label>
            <input type="file" name="video" class="form-control" accept="video/mp4,video/webm,video/ogg">
            @if(isset($seccion->video))
                <small>Video actual: <a href="{{ asset('storage/' . $seccion->video) }}" target="_blank">Ver</a></small>
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">O URL de YouTube (opcional)</label>
            <input type="url" name="youtube_url" class="form-control" value="{{ old('youtube_url', $seccion->youtube_url ?? '') }}" placeholder="https://www.youtube.com/watch?v=...">
        </div>

        {{-- Cuadro tipo tabla --}}
        <h5 class="mt-4">Cuadro tipo tabla</h5>
        <table class="table table-bordered" id="tabla-cuadro">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Archivo</th>
                    <th>Mostrar</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($seccion->cuadros ?? [] as $cuadro)
                <tr>
                    <td><input type="text" name="cuadro_titulo[]" class="form-control" value="{{ $cuadro->titulo }}"></td>
                    <td><input type="text" name="cuadro_autor[]" class="form-control" value="{{ $cuadro->autor }}"></td>
                    <td>
                        <input type="file" name="cuadro_archivo[]" class="form-control">
                        @if($cuadro->archivo)
                        <small>Archivo actual: <a href="{{ asset('storage/' . $cuadro->archivo) }}" target="_blank">Ver</a></small>
                        @endif
                    </td>
                    <td class="text-center"><input type="checkbox" name="mostrar_cuadro[]" value="1" {{ $cuadro->mostrar ? 'checked' : '' }}></td>
                    <td class="text-center"><button type="button" class="btn btn-danger btn-sm eliminar-fila">✖</button></td>
                </tr>
                @empty
                <tr>
                    <td><input type="text" name="cuadro_titulo[]" class="form-control"></td>
                    <td><input type="text" name="cuadro_autor[]" class="form-control"></td>
                    <td><input type="file" name="cuadro_archivo[]" class="form-control"></td>
                    <td class="text-center"><input type="checkbox" name="mostrar_cuadro[]" value="1"></td>
                    <td class="text-center"><button type="button" class="btn btn-danger btn-sm eliminar-fila">✖</button></td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <button type="button" id="agregar-fila" class="btn btn-secondary mb-3">+ Agregar fila</button>
        <br>

        {{-- Botones --}}
        <button type="submit" class="btn btn-primary mt-1">Actualizar</button>
        <a href="{{ route('secciones.listado') }}" class="btn btn-outline-secondary mt-1">← Regresar a Secciones</a>
    </form>
</main>
@endsection

@section('scripts')
{{-- Agregar/eliminar filas dinámicamente --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabla = document.getElementById('tabla-cuadro').getElementsByTagName('tbody')[0];
    const btnAgregar = document.getElementById('agregar-fila');

    btnAgregar.addEventListener('click', function() {
        const nuevaFila = document.createElement('tr');
        nuevaFila.innerHTML = `
            <td><input type="text" name="cuadro_titulo[]" class="form-control"></td>
            <td><input type="text" name="cuadro_autor[]" class="form-control"></td>
            <td><input type="file" name="cuadro_archivo[]" class="form-control"></td>
            <td class="text-center"><input type="checkbox" name="mostrar_cuadro[]" value="1"></td>
            <td class="text-center"><button type="button" class="btn btn-danger btn-sm eliminar-fila">✖</button></td>
        `;
        tabla.appendChild(nuevaFila);
    });

    tabla.addEventListener('click', function(e) {
        if(e.target && e.target.classList.contains('eliminar-fila')) {
            e.target.closest('tr').remove();
        }
    });
});
</script>

{{-- CKEditor para la descripción --}}
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
