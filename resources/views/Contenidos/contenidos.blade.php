@extends('base.layout')

@section('contenido')
<main class="p-4" style="background-color: #fff; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
    <h2>Crear Contenido</h2>

    <form action="{{ route('contenidos.guardar') }}" method="POST" enctype="multipart/form-data">
        @csrf

      
        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" value="{{ old('titulo') }}" required>
        </div>

      
        <div class="mb-3">
            <label class="form-label">Sección</label>
            <select name="seccion_id" class="form-select" required>
                @foreach($secciones as $sec)
                    <option value="{{ $sec->id }}">{{ $sec->nombre }}</option>
                @endforeach
            </select>
        </div>

      
        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control">{{ old('descripcion') }}</textarea>
        </div>


        <div class="mb-3">
            <label class="form-label">Imagen principal (opcional)</label>
            <input type="file" name="imagen" class="form-control">
        </div>

       
        <div class="mb-3">
            <label class="form-label">Archivos adicionales</label>
            <input type="file" name="archivos[]" multiple class="form-control">
        </div>

       
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
                <tr>
                    <td><input type="text" name="cuadros[0][titulo]" class="form-control"></td>
                    <td><input type="text" name="cuadros[0][autor]" class="form-control"></td>
                    <td><input type="file" name="cuadros[0][archivo]" class="form-control"></td>
                    <td class="text-center"><input type="checkbox" name="cuadros[0][mostrar]" value="1"></td>
                    <td class="text-center"><button type="button" class="btn btn-danger btn-sm eliminar-fila">✖</button></td>
                </tr>
            </tbody>
        </table>

        <button type="button" id="agregar-fila" class="btn btn-secondary mb-3">+ Agregar fila</button>
        <br>

        <button type="submit" class="btn btn-primary mt-1">Guardar Contenido</button>
    </form>
</main>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let index = 0; 
    const tabla = document.getElementById('tabla-cuadro').getElementsByTagName('tbody')[0];
    const btnAgregar = document.getElementById('agregar-fila');

    btnAgregar.addEventListener('click', function() {
        index++;
        const nuevaFila = document.createElement('tr');
        nuevaFila.innerHTML = `
            <td><input type="text" name="cuadros[${index}][titulo]" class="form-control"></td>
            <td><input type="text" name="cuadros[${index}][autor]" class="form-control"></td>
            <td><input type="file" name="cuadros[${index}][archivo]" class="form-control"></td>
            <td class="text-center"><input type="checkbox" name="cuadros[${index}][mostrar]" value="1"></td>
            <td class="text-center"><button type="button" class="btn btn-danger btn-sm eliminar-fila">✖</button></td>
        `;
        tabla.appendChild(nuevaFila);
    });


    tabla.addEventListener('click', function(e){
        if(e.target && e.target.classList.contains('eliminar-fila')){
            e.target.closest('tr').remove();
        }
    });

    
    ClassicEditor
        .create(document.querySelector('#descripcion'))
        .catch(error => { console.error(error); });
});
</script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
@endsection
