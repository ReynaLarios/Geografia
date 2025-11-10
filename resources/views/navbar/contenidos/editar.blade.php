@extends('base.layout')

@section('contenido')
<div class="container py-4">
    <h2>Editar Submenú</h2>

    <form action="{{ route('navbar.contenidos.actualizar', $navbar_contenido->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" name="titulo" id="titulo" class="form-control" value="{{ $navbar_contenido->titulo }}" required>
        </div>

       <textarea name="descripcion" id="descripcion" class="form-control" rows="10">
    {!! old('descripcion', $navbar_seccion->descripcion ?? '') !!}
</textarea>
        <div class="mb-3">
            <label class="form-label">Imagen principal (opcional)</label>
            <input type="file" name="imagen" class="form-control">
            @if($navbar_contenido->imagen)
                <div class="mt-2">
                    <img src="{{ asset('storage/'.$navbar_contenido->imagen) }}" alt="Imagen" style="max-width: 150px; border-radius: 6px;">
                </div>
            @endif
        </div>

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
        </tr>
    </thead>
    <tbody>
        @foreach($navbar_contenido->cuadros as $cuadro)
        <tr>
            <td>{{ $cuadro->titulo }}</td>
            <td>{{ $cuadro->autor }}</td>
            <td>
                @if($cuadro->archivo)
                    @php
                        $nombre = pathinfo($cuadro->archivo, PATHINFO_FILENAME);
                        $ext = pathinfo($cuadro->archivo, PATHINFO_EXTENSION);
                        $tamano = Storage::disk('public')->size($cuadro->archivo);
                        $tamanoMB = number_format($tamano / 1024 / 1024, 2);
                    @endphp
                    {{ Str::limit($nombre, 20) }}.{{ $ext }} ({{ $tamanoMB }} MB)
                @else
                    Sin archivo
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


        <button type="button" id="agregar-fila" class="btn btn-secondary mb-3">+ Agregar fila</button>
        <br>
        <button type="submit" class="btn btn-primary mt-1">Actualizar</button>
    </form>
</main>

{{-- Script para agregar/eliminar filas dinámicamente --}}
@section('scripts')
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

@endsection
