@extends('base.layout')

@section('contenido')
<h2>Crear Sección Navbar</h2>
<form action="{{ route('navbar-secciones.guardar') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre de la sección</label>
        <input type="text" name="nombre" id="nombre" class="form-control" required>
    </div>
    <button class="btn btn-success">Guardar</button>
</form>
@endsection
