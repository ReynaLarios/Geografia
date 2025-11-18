@extends('base.layout')

@section('contenido')
<div class="container mt-4">
    <h2 class="mb-4 text-center">Listado de Secciones</h2>

    <a href="{{ route('navbar.secciones.crear') }}" class="btn btn-success mb-3">+ Agregar Sección</a>

    @if(session('ok'))
        <div class="alert alert-success">{{ session('ok') }}</div>
    @endif

    <table class="table table-bordered align-middle text-center">
        <thead class="table-light">
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($secciones as $seccion)
            <tr>
                <td>{{ $seccion->nombre }}</td>
                <td>{{ Str::limit($seccion->descripcion, 80) }}</td>
                <td>
                    <a href="{{ route('navbar.secciones.mostrar', $seccion->id) }}" class="btn btn-info btn-sm">Ver</a>
                    <a href="{{ route('navbar.secciones.editar', $seccion->id) }}" class="btn btn-warning btn-sm"> Editar</a>
                    <form action="{{ route('navbar.secciones.borrar', $seccion->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar esta sección?')">🗑️ Borrar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
