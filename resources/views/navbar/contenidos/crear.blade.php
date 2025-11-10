@extends('base.layout')

@section('contenido')
<div class="container mt-4">
    <h2 class="mb-4 text-center">Agregar Nuevo Contenido</h2>

    <form action="{{ route('navbar.contenidos.guardar') }}" method="POST" class="p-4 bg-light rounded shadow-sm">
        @csrf

        {{-- Selección de sección a la que pertenece --}}
        <div class="mb-3">
            <label for="seccion_id" class="form-label">Selecciona la Sección</label>
            <select name="seccion_id" id="seccion_id" class="form-select" required>
                <option value="">-- Selecciona una sección --</option>
                @foreach($navbarSecciones as $sec)
                    <option value="{{ $sec->id }}">{{ $sec->nombre }}</option>
                @endforeach
            </select>
        </div>

        {{-- Nombre del contenido --}}
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del contenido</label>
            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ejemplo: Inicio, Contacto, Acerca de..." required>
        </div>

        {{-- URL o ruta del contenido (opcional) --}}
        <div class="mb-3">
            <label for="url" class="form-label">URL / Ruta del contenido</label>
            <input type="text" name="url" id="url" class="form-control" placeholder="Ejemplo: /inicio, /contacto">
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-success">Guardar</button>
            <a href="{{ route('navbar.secciones.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
