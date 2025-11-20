@extends('base.layout')

@section('contenido')
<div class="container mt-4">
    <h2>Listado de Personas</h2>
    <a href="{{ route('personas.create') }}" class="btn btn-primary mb-3">Crear Persona</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Datos Adicionales</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($personas as $persona)
            <tr>
                <td>
                    @if($persona->foto)
                        <img src="{{ asset('storage/' . $persona->foto) }}" width="50">
                    @endif
                </td>
                <td>{{ $persona->nombre }}</td>
                <td>{{ $persona->email }}</td>
                <td>{{ $persona->datos_adicionales }}</td>
                <td>
                    <a href="{{ route('personas.show', $persona->id) }}" class="btn btn-info btn-sm">Ver</a>
                    <a href="{{ route('personas.edit', $persona->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('personas.destroy', $persona->id) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                        onclick="return confirm('¿Seguro que quieres eliminar esta persona?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
