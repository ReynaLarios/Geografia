@extends('base.layout')

@section('contenido')
<main class="p-4" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
    <h2>Editar Sección</h2>

    <form action="{{ route('secciones.actualizar', $seccion->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nombre de la sección</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $seccion->nombre) }}" required>
        </div>

     
        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control">{{ old('descripcion', $seccion->descripcion) }}</textarea>
        </div>

      
        <div class="mb-3">
            <label class="form-label">Imagen principal (opcional)</label>
            <input type="file" name="imagen" class="form-control" id="input-imagen">
            @if($seccion->imagen)
                <div class="mt-2 mb-2" id="imagen-actual">
                    <img src="{{ asset('storage/'.$seccion->imagen) }}" alt="Imagen" style="max-width: 150px; border-radius: 6px;">
                    <button type="button" class="btn btn-danger btn-sm ms-2" id="eliminar-imagen">Eliminar</button>
                </div>
            @endif
            <input type="hidden" name="eliminar_imagen" id="hidden-eliminar-imagen" value="0">
        </div>
        
        
        <div class="mb-3">
            <label class="form-label">Archivos adicionales</label>
            @if($seccion->archivos && $seccion->archivos->count())
                <ul class="list-group mb-2" id="lista-archivos">
                    @foreach($seccion->archivos as $archivo)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="{{ asset('storage/' . $archivo->ruta) }}" target="_blank">{{ $archivo->nombre }}</a>
                            <button type="button" class="btn btn-danger btn-sm eliminar-archivo" data-id="{{ $archivo->id }}">Eliminar</button>
                        </li>
                    @endforeach
                </ul>
            @endif
            <input type="file" name="archivos[]" multiple class="form-control">
            <input type="hidden" name="archivos_eliminados" id="archivos-eliminados">
        </div>

        
        <h5 class="mt-4">Cuadros</h5>
        <table class="table table-bordered table-cuadros" id="tabla-cuadro">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Archivo</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($seccion->cuadros ?? [] as $cuadro)
                <tr>
                    <td>
                        <input type="hidden" name="cuadro_id[]" value="{{ $cuadro->id }}">
                        <input type="text" name="cuadro_titulo[]" class="form-control" value="{{ $cuadro->titulo }}">
                    </td>
                    <td><input type="text" name="cuadro_autor[]" class="form-control" value="{{ $cuadro->autor }}"></td>
                    <td>
                        <input type="file" name="cuadro_archivo[]" class="form-control">
                        @if($cuadro->archivo)
                            <small>Archivo actual: <a href="{{ asset('storage/' . $cuadro->archivo) }}" target="_blank">Ver</a></small>
                        @endif
                    </td>
                    <td class="text-center"><button type="button" class="btn btn-danger btn-sm eliminar-fila">✖</button></td>
                </tr>
                @empty
                <tr>
                    <td><input type="hidden" name="cuadro_id[]" value="0"><input type="text" name="cuadro_titulo[]" class="form-control"></td>
                    <td><input type="text" name="cuadro_autor[]" class="form-control"></td>
                    <td><input type="file" name="cuadro_archivo[]" class="form-control"></td>
                    <td class="text-center"><button type="button" class="btn btn-danger btn-sm eliminar-fila">✖</button></td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <button type="button" id="agregar-fila" class="btn btn-secondary mb-3">+ Agregar fila</button>
        <br>

        
        <button type="submit" class="btn btn-primary mt-1">Actualizar</button>
        <a href="{{ route('secciones.listado') }}" class="btn btn-outline-secondary mt-1">← Regresar a Secciones</a>
    </form>
</main>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
 
    ClassicEditor.create(document.querySelector('#descripcion'))
        .catch(error => console.error(error));


    const tabla = document.getElementById('tabla-cuadro').getElementsByTagName('tbody')[0];
    const btnAgregar = document.getElementById('agregar-fila');

    btnAgregar.addEventListener('click', function() {
        const nuevaFila = document.createElement('tr');
        nuevaFila.innerHTML = `
            <td><input type="hidden" name="cuadro_id[]" value="0"><input type="text" name="cuadro_titulo[]" class="form-control"></td>
            <td><input type="text" name="cuadro_autor[]" class="form-control"></td>
            <td><input type="file" name="cuadro_archivo[]" class="form-control"></td>
            <td class="text-center"><button type="button" class="btn btn-danger btn-sm eliminar-fila">✖</button></td>
        `;
        tabla.appendChild(nuevaFila);
    });

    tabla.addEventListener('click', function(e) {
        if(e.target && e.target.classList.contains('eliminar-fila')) {
            e.target.closest('tr').remove();
        }
    });

  
    const btnEliminarImagen = document.getElementById('eliminar-imagen');
    if(btnEliminarImagen){
        btnEliminarImagen.addEventListener('click', function() {
            document.getElementById('input-imagen').value = '';
            document.getElementById('hidden-eliminar-imagen').value = '1';
            document.getElementById('imagen-actual').remove();
        });
    }


    const archivosEliminadosInput = document.getElementById('archivos-eliminados');
    document.querySelectorAll('.eliminar-archivo').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const current = archivosEliminadosInput.value ? JSON.parse(archivosEliminadosInput.value) : [];
            current.push(id);
            archivosEliminadosInput.value = JSON.stringify(current);
            this.closest('li').remove();
        });
    });
});
</script>
@endsection
