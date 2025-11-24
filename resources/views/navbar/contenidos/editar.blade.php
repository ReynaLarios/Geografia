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
                @foreach($secciones as $seccion)
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
                <img src="{{ asset('storage/'.$contenido->imagen) }}" class="img-fluid mt-2 rounded" style="max-height:200px;">
            @endif
        </div>

        {{-- ARCHIVOS ADICIONALES --}}
        <div class="mb-3">
            <label class="form-label">Archivos adicionales</label>
            <input type="file" name="archivos[]" multiple class="form-control">
            @if($contenido->archivos->count())
                <ul class="mt-2">
                    @foreach($contenido->archivos as $archivo)
                        <li>
                            <a href="{{ asset('storage/'.$archivo->ruta) }}" target="_blank">{{ $archivo->nombre }}</a>
                            <small class="text-muted">{{ number_format(Storage::disk('public')->size($archivo->ruta)/1024/1024,2) }} MB</small>
                        </li>
                    @endforeach
                </ul>
            @endif
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

    tabla.addEventListener('click', function(e){
        if(e.target && e.target.classList.contains('eliminar-fila')){
            e.target.closest('tr').remove();
        }
    });

    ClassicEditor.create(document.querySelector('#descripcion'))
        .catch(error => console.error(error));
});
</script>
@endsection
