@extends('base.layout')

@section('contenido')
<div class="container mt-4">
    <h2 class="mb-4 text-center">Editar Contenido del Navbar</h2>

    <form action="{{ route('navbar.contenidos.actualizar', $contenido->id) }}" method="POST" enctype="multipart/form-data" class="p-4 bg-light rounded shadow-sm">
        @csrf
        @method('PUT')

        {{-- SELECCIÓN DE SECCIÓN --}}
 <div class="mb-3">
    <label class="form-label">Sección del Navbar</label>
    <select name="navbar_seccion_id" class="form-control" required>
        <option value="">Selecciona una sección…</option>
        @foreach($navbarSecciones as $seccion)
            <option value="{{ $seccion->id }}" {{ $contenido->navbar_seccion_id == $seccion->id ? 'selected' : '' }}>
                {{ $seccion->nombre }}
            </option>
        @endforeach
    </select>
</div>


        {{-- TÍTULO --}}
        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" value="{{ old('titulo', $contenido->titulo) }}" required>
        </div>

        {{-- DESCRIPCIÓN --}}
        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control">{{ old('descripcion', $contenido->descripcion) }}</textarea>
        </div>

        {{-- IMAGEN PRINCIPAL --}}
        <div class="mb-3">
            <label class="form-label">Imagen principal (opcional)</label>
            <input type="file" name="imagen" class="form-control">
            @if($contenido->imagen)
                <div class="mt-2 position-relative d-inline-block">
                    <img src="{{ asset('storage/'.$contenido->imagen) }}" class="img-fluid rounded" style="max-height:200px;">
                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 eliminar-imagen">✖</button>
                </div>
            @endif
            <input type="hidden" name="eliminar_imagen" value="0">
        </div>

        {{-- ARCHIVOS ADICIONALES --}}
        <div class="mb-3">
            <label class="form-label">Archivos adicionales</label>
            <input type="file" name="archivos[]" multiple class="form-control">
            @if($contenido->archivos->count())
                <ul class="mt-2">
                    @foreach($contenido->archivos as $archivo)
                        <li class="d-flex align-items-center">
                            <a href="{{ asset('storage/'.$archivo->ruta) }}" target="_blank">{{ $archivo->nombre }}</a>
                            <small class="text-muted ms-2">{{ number_format(Storage::disk('public')->size($archivo->ruta)/1024/1024,2) }} MB</small>
                            <button type="button" class="btn btn-sm btn-danger ms-2 eliminar-archivo" data-id="{{ $archivo->id }}">✖</button>
                        </li>
                    @endforeach
                </ul>
            @endif
            <input type="hidden" name="archivos_eliminar" value="">
        </div>

        {{-- CUADROS --}}
        <h5 class="mt-4">Cuadros</h5>
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
                @foreach($contenido->cuadros as $index => $cuadro)
                    <tr>
                        <td>
                            <input type="text" name="cuadros[{{ $index }}][titulo]" class="form-control" value="{{ $cuadro->titulo }}">
                            <input type="hidden" name="cuadros[{{ $index }}][id]" value="{{ $cuadro->id }}">
                        </td>
                        <td><input type="text" name="cuadros[{{ $index }}][autor]" class="form-control" value="{{ $cuadro->autor }}"></td>
                        <td>
                            <input type="file" name="cuadros[{{ $index }}][archivo]" class="form-control">
                            @if($cuadro->archivo)
                                <small class="d-block mt-1"><a href="{{ asset('storage/'.$cuadro->archivo) }}" target="_blank">Archivo actual</a></small>
                            @endif
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm eliminar-fila">✖</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="button" id="agregar-fila" class="btn btn-secondary mb-3">+ Agregar fila</button>
        <br>

        <button type="submit" class="btn btn-primary mt-1">Actualizar Contenido</button>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let index = {{ count($contenido->cuadros) }};
    const tabla = document.getElementById('tabla-cuadro').getElementsByTagName('tbody')[0];
    const btnAgregar = document.getElementById('agregar-fila');

    // Agregar fila de cuadro
    btnAgregar.addEventListener('click', function() {
        const nuevaFila = document.createElement('tr');
        nuevaFila.innerHTML = `
            <td><input type="text" name="cuadros[${index}][titulo]" class="form-control"></td>
            <td><input type="text" name="cuadros[${index}][autor]" class="form-control"></td>
            <td><input type="file" name="cuadros[${index}][archivo]" class="form-control"></td>
            <td class="text-center"><button type="button" class="btn btn-danger btn-sm eliminar-fila">✖</button></td>
        `;
        tabla.appendChild(nuevaFila);
        index++;
    });

    // Eliminar fila de cuadro
    tabla.addEventListener('click', function(e){
        if(e.target && e.target.classList.contains('eliminar-fila')){
            e.target.closest('tr').remove();
        }
    });

    // Editor CKEditor
    ClassicEditor.create(document.querySelector('#descripcion'))
        .catch(error => console.error(error));

    // Eliminar imagen principal
    document.querySelectorAll('.eliminar-imagen').forEach(btn => {
        btn.addEventListener('click', function() {
            if (confirm('¿Eliminar imagen principal?')) {
                document.querySelector('input[name="eliminar_imagen"]').value = 1;
                btn.closest('div').remove();
            }
        });
    });

    // Eliminar archivos existentes
    let archivosEliminar = [];
    document.querySelectorAll('.eliminar-archivo').forEach(btn => {
        btn.addEventListener('click', function() {
            if (confirm('¿Eliminar este archivo?')) {
                archivosEliminar.push(btn.dataset.id);
                document.querySelector('input[name="archivos_eliminar"]').value = archivosEliminar.join(',');
                btn.closest('li').remove();
            }
        });
    });
});
</script>
@endsection
