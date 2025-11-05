@extends('base.layout')

@section('contenido')
<div class="container mt-4">
    <h2 class="mb-4 text-center">Agregar Nueva Sección al Navbar</h2>

    <form action="{{ route('navbar.secciones.guardar') }}" method="POST" class="p-4 bg-light rounded shadow-sm">
        @csrf

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de la sección</label>
            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ejemplo: Inicio, Contacto, Acerca de..." required>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-success">Guardar</button>
            <a href="{{ route('navbar.secciones.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
