@extends('base.layout')

@section('contenido')
<main class="p-4" style="background:#fff; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1);">

    <h2 class="mb-3">Crear Cuadro</h2>

    <form action="{{ route('cuadros.guardar') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Autor</label>
            <input type="text" name="autor" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Archivo</label>
            <input type="file" name="archivo" class="form-control" accept=".pdf,.doc,.docx,.pptx,.xlsx">
        </div>

        <button class="btn btn-primary">Guardar</button>
        <a href="{{ route('cuadros.listado') }}" class="btn btn-outline-secondary">Cancelar</a>
    </form>

</main>
@endsection

