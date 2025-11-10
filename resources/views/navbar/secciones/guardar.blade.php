@extends('base.layout')

@section('contenido')
<div class="container mt-4">
    <h2>Crear nueva sección</h2>

    <form action="{{ route('navbar.secciones.guardar') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nombre de la sección:</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <button class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection
