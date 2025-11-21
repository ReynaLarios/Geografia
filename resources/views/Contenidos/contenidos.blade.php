@extends('base.layout')

@section('contenido')
<main class="p-4" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
    <h2>Crear Contenido</h2>

    <form action="{{ route('contenidos.guardar') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Título --}}
        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" value="{{ old('titulo') }}" required>
        </div>

        {{-- Sección --}}
        <div class="mb-3">
            <label class="form-label">Sección</label>
            <select name="seccion_id" class="form-select" required>
                @foreach($secciones as $sec)
                    <option value="{{ $sec->id }}" {{ old('seccion_id') == $sec->id ? 'selected' : '' }}>
                        {{ $sec->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Descripción --}}
        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="10">{{ old('descripcion') }}</textarea>
        </div>

        {{-- Imagen principal --}}
        <div class="mb-3">
            <label class="form-label">Imagen principal (opcional)</label>
            <input type="file" name="imagen" class="form-control">
        </div>

        {{-- Archivos adicionales --}}
        <div class="mb-3">
            <label class="form-label">Archivos adicionales</label>
            <input type="file" name="archivos[]" multiple class="form-control">
        </div>

        {{-- Cuadro tipo tabla --}}
        <h5 class="mt-4">Cuadro tipo tabla</h5>
        <table class="table table-bordered" id="tabla-cuadro">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Archivo</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                {{-- No hay cuadros iniciales, se agregan dinámicamente --}}
            </tbody>
        </table>
        <button type="button" id="agregar-fila" class="btn btn-secondary mb-3">+ Agregar fila</button>
        <br>
        <button type="submit" class="btn btn-primary mt-1">Crear</button>
    </form>
</main>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabla = document.getElementById('tabla-cuadro').getElementsByTagName('tbody')[0];
    const btnAgregar = document.getElementById('agregar-fila');

    // Agregar nueva fila
    btnAgregar.addEventListener('click', function() {
        const index = tabla.rows.length;
        const nuevaFila = document.createElement('tr');
        nuevaFila.innerHTML = `
            <td>
                <input type="text" name="cuadro_titulo[]" class="form-control">
                <input type="hidden" name="cuadro_id[]" value="0">
            </td>
            <td><input type="text" name="cuadro_autor[]" class="form-control"></td>
            <td><input type="file" name="cuadro_archivo[]" class="form-control"></td>
            <td class="text-center"><button type="button" class="btn btn-danger btn-sm eliminar-fila">✖</button></td>
        `;
        tabla.appendChild(nuevaFila);
    });

    // Eliminar fila
    tabla.addEventListener('click', function(e) {
        if(e.target && e.target.classList.contains('eliminar-fila')) {
            e.target.closest('tr').remove();
        }
    });

    // CKEditor
    ClassicEditor
        .create(document.querySelector('#descripcion'), {
            toolbar: [ 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ]
        })
        .catch(error => { console.error(error); });
});
</script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
@endsection
