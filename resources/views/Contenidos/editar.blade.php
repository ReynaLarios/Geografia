@extends('base.layout')

@section('contenido')
<main class="p-4" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
    <h2>Editar Contenido</h2>

    <form action="{{ route('contenidos.actualizar', $contenido->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Título --}}
        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" value="{{ old('titulo', $contenido->titulo) }}" required>
        </div>

        {{-- Sección --}}
        <div class="mb-3">
            <label class="form-label">Sección</label>
            <select name="seccion_id" class="form-select" required>
                @foreach($secciones as $sec)
                    <option value="{{ $sec->id }}"
                        @selected(
                            old('seccion_id') == $sec->id ||
                            (old('seccion_id') === null && isset($seccionId) && $seccionId == $sec->id) ||
                            (old('seccion_id') === null && !isset($seccionId) && $contenido->seccion_id == $sec->id)
                        )>
                        {{ $sec->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Descripción --}}
        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="10">{!! old('descripcion', $contenido->descripcion) !!}</textarea>
        </div>

        {{-- Imagen principal --}}
        <div class="mb-3">
            <label class="form-label">Imagen principal (opcional)</label>
            <input type="file" name="imagen" class="form-control">

            @if($contenido->imagen && Storage::disk('public')->exists($contenido->imagen))
                <div class="mt-2 d-flex align-items-center">
                    <img src="{{ asset('storage/'.$contenido->imagen) }}" alt="Imagen" style="max-width: 150px; border-radius: 6px; margin-right:10px;">
                    <div class="form-check">
                        <input type="checkbox" name="eliminar_imagen" class="form-check-input" id="eliminarImagen">
                        <label class="form-check-label text-danger" for="eliminarImagen">Eliminar imagen actual</label>
                    </div>
                </div>
            @endif
        </div>

        {{-- Archivos adicionales --}}
        <div class="mb-3">
            <label class="form-label">Archivos adicionales</label>
            <input type="file" name="archivos[]" multiple class="form-control">

            @if($contenido->archivos->count())
                <ul class="list-group mt-2">
                    @foreach($contenido->archivos as $archivo)
                        @php
                            $existe = Storage::disk('public')->exists($archivo->ruta);
                            $tamanoMB = $existe ? number_format(Storage::disk('public')->size($archivo->ruta)/1024/1024,2) : 0;
                        @endphp
                        <li class="list-group-item d-flex justify-content-between align-items-center">

                            {{-- Aquí sí mostrar el nombre real --}}
                            @if($existe)
                                <a href="{{ asset('storage/'.$archivo->ruta) }}" target="_blank">
                                    {{ $archivo->nombre_original ?? 'Ver archivo' }}
                                </a>
                                <small class="text-muted ms-2">({{ $tamanoMB }} MB)</small>
                            @else
                                <span>Sin archivo</span>
                            @endif

                            <div class="form-check ms-2">
                                <input type="checkbox" name="archivos_eliminados[]" value="{{ $archivo->id }}" class="form-check-input" id="archivo{{ $archivo->id }}">
                                <label class="form-check-label text-danger" for="archivo{{ $archivo->id }}">Eliminar</label>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
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
                @foreach($contenido->cuadros as $cuadro)
                <tr>
                    <td>
                        <input type="text" name="cuadro_titulo[]" class="form-control" value="{{ $cuadro->titulo }}">
                        <input type="hidden" name="cuadro_id[]" value="{{ $cuadro->id }}">
                    </td>

                    <td><input type="text" name="cuadro_autor[]" class="form-control" value="{{ $cuadro->autor }}"></td>

                    <td>
                        {{-- Mostrar SOLO "ver archivo" --}}
                        @if($cuadro->archivo && Storage::disk('public')->exists($cuadro->archivo))
                            <a href="{{ asset('storage/'.$cuadro->archivo) }}" target="_blank">Ver archivo</a>

                            {{-- Checkbox eliminar archivo --}}
                            <div class="form-check mt-1">
                                <input type="checkbox" name="cuadro_archivo_eliminado[]" value="{{ $cuadro->id }}" class="form-check-input">
                                <label class="form-check-label text-danger">Eliminar archivo</label>
                            </div>
                        @endif

                        <input type="file" name="cuadro_archivo[]" class="form-control mt-1">
                    </td>

                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-sm eliminar-fila">✖</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <button type="button" id="agregar-fila" class="btn btn-secondary mb-3">+ Agregar fila</button>

        <button type="submit" class="btn btn-primary mt-1">Actualizar</button>
    </form>
</main>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    const tabla = document.querySelector('#tabla-cuadro tbody');
    const btnAgregar = document.getElementById('agregar-fila');

    btnAgregar.addEventListener('click', function() {
        const fila = document.createElement('tr');
        fila.innerHTML = `
            <td>
                <input type="text" name="cuadro_titulo[]" class="form-control">
                <input type="hidden" name="cuadro_id[]" value="0">
            </td>
            <td><input type="text" name="cuadro_autor[]" class="form-control"></td>
            <td><input type="file" name="cuadro_archivo[]" class="form-control"></td>
            <td class="text-center"><button type="button" class="btn btn-danger btn-sm eliminar-fila">✖</button></td>
        `;
        tabla.appendChild(fila);
    });

    tabla.addEventListener('click', function(e) {
        if(e.target.classList.contains('eliminar-fila')){
            e.target.closest('tr').remove();
        }
    });

    ClassicEditor.create(document.querySelector('#descripcion')).catch(err=>console.error(err));

});
</script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
@endsection
