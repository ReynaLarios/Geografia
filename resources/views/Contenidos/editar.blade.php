@extends('base.layout')

@section('contenido')
<main>
    <h2 class="text-xl font-semibold mb-4">Editar Contenido</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('contenidos.update', $contenido->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" value="{{ old('titulo', $contenido->titulo) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" rows="5" required>{{ old('descripcion', $contenido->descripcion) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Sección</label>
            <select name="seccion_id" class="form-control" required>
                <option value="">Selecciona una sección</option>
                @foreach($secciones as $sec)
                    <option value="{{ $sec->id }}" {{ $contenido->seccion_id == $sec->id ? 'selected' : '' }}>
                        {{ $sec->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Imagen (opcional)</label>
            <input type="file" name="imagen" class="form-control">
            @if($contenido->imagen)
                <img src="{{ asset('storage/' . $contenido->imagen) }}" alt="Imagen actual" class="mt-2 img-fluid" style="max-width:200px;">
            @endif
        </div>

        <!-- Checkbox para activar/desactivar tabla de archivos -->
        <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" id="activarArchivos" checked>
            <label class="form-check-label" for="activarArchivos">Agregar archivos</label>
        </div>

        <!-- Tabla de archivos -->
        <div id="tablaArchivosContainer">
            <div class="page-container mt-3">
                <table class="table-cebra" id="tabla-archivos">
                    <thead>
                        <tr>
                            <th>Adjunto</th>
                            <th>Tamaño</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="file" name="archivos[]" class="archivo-input" /></td>
                            <td class="archivo-tamano">0 MB</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <button type="submit" class="fancy mt-3">Actualizar Contenido</button>
    </form>
</main>

<!-- Scripts -->
<script>
    document.querySelectorAll('.archivo-input').forEach(function(input) {
        input.addEventListener('change', function() {
            const file = input.files[0];
            const sizeCell = input.closest('tr').querySelector('.archivo-tamano');
            sizeCell.textContent = file ? (file.size / (1024*1024)).toFixed(2) + ' MB' : '0 MB';
        });
    });

    document.getElementById('activarArchivos').addEventListener('change', function() {
        document.getElementById('tablaArchivosContainer').style.display = this.checked ? 'block' : 'none';
    });
</script>
@endsection
