@extends('base.layout')

@section('contenido')
<div class="container mt-4">
    <h2 class="mb-4 text-center">Editar Contenido Navbar</h2>

    <form action="{{ route('navbar.contenidos.actualizar', $contenido->id) }}" method="POST" enctype="multipart/form-data" class="p-4 bg-light rounded shadow-sm">
        @csrf
        @method('PUT')

        {{-- SELECCIONAR SECCIÓN --}}
        <div class="mb-3">
            <label class="form-label">Sección del Navbar</label>
            <select name="navbar_seccion_id" class="form-control" required>
                <option value="">Selecciona una sección…</option>
                @foreach($secciones as $seccion)
                    <option value="{{ $seccion->id }}" {{ $contenido->navbar_seccion_id == $seccion->id ? 'selected' : '' }}>
                        {{ $seccion->titulo }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- resto del formulario igual que crear --}}
        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" value="{{ old('titulo', $contenido->titulo) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control">{{ old('descripcion', $contenido->descripcion) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Imagen principal (opcional)</label>
            <input type="file" name="imagen" class="form-control">
            @if($contenido->imagen)
                <p class="mt-2">Imagen actual: <img src="{{ asset('storage/' . $contenido->imagen) }}" style="max-width:150px;"></p>
            @endif
        </div>

        {{-- Cuadros --}}
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
                @forelse($contenido->cuadros as $i => $cuadro)
                <tr>
                    <td><input type="text" name="cuadros[{{ $i }}][titulo]" class="form-control" value="{{ $cuadro->titulo }}"></td>
                    <td><input type="text" name="cuadros[{{ $i }}][autor]" class="form-control" value="{{ $cuadro->autor }}"></td>
                    <td>
                        <input type="file" name="cuadros[{{ $i }}][archivo]" class="form-control">
                        @if($cuadro->archivo)
                            <p class="mt-1"><a href="{{ asset('storage/' . $cuadro->archivo) }}" target="_blank">Archivo actual</a></p>
                        @endif
                    </td>
                    <td class="text-center"><button type="button" class="btn btn-danger btn-sm eliminar-fila">✖</button></td>
                </tr>
                @empty
                <tr>
                    <td><input type="text" name="cuadros[0][titulo]" class="form-control"></td>
                    <td><input type="text" name="cuadros[0][autor]" class="form-control"></td>
                    <td><input type="file" name="cuadros[0][archivo]" class="form-control"></td>
                    <td class="text-center"><button type="button" class="btn btn-danger btn-sm eliminar-fila">✖</button></td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <button type="button" id="agregar-fila" class="btn btn-secondary mb-3">+ Agregar fila</button>
        <br>
        <button type="submit" class="btn btn-primary mt-1">Actualizar Contenido</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let index = {{ $contenido->cuadros->count() }};
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

    ClassicEditor.create(document.querySelector('#descripcion')).catch(error => { console.error(error); });
});
</script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
@endsection
