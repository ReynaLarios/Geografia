@extends('base.layout')

@section('contenido')
<div class="container mt-4">
    <h2 class="mb-4 text-center">Editar Sección del Navbar</h2>

    <form action="{{ route('navbar.secciones.actualizar', $navbar_seccion->id) }}" method="POST" class="p-4 bg-light rounded shadow-sm">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de la sección</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $navbar_seccion->nombre }}" required>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('navbar.secciones.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
