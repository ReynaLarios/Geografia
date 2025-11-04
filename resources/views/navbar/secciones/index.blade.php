@extends('base.layout')

@section('contenido')
<h2>Secciones de Navbar Horizontal</h2>
<a href="{{ route('navbar-secciones.crear') }}" class="btn btn-success mb-2">+ Agregar Sección</a>

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($secciones as $sec)
        <tr>
            <td>{{ $sec->id }}</td>
            <td>{{ $sec->nombre }}</td>
            <td>
                <a href="{{ route('navbar-secciones.editar', $sec->id) }}" class="btn btn-primary btn-sm">Editar</a>
                <form action="{{ route('navbar-secciones.borrar', $sec->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Seguro?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm">Borrar</button>
                </form>
                <a href="{{ route('navbar-contenidos.crear', $sec->id) }}" class="btn btn-info btn-sm">+ Submenú</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
