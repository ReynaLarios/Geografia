@extends('layouts.app') {{-- Ajusta al layout que uses en tu panel --}}

@section('contenido')
<div class="container mt-4">
    <h3 class="mb-3">Gestión de Archivos</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Formulario de subida --}}
    <form action="{{ route('archivos.guardar', $contenido_id ?? '') }}" method="POST" enctype="multipart/form-data" class="mb-4">
        @csrf
        <div class="row g-3">
            <div class="col-md-4">
                <input type="text" name="nombre" class="form-control" placeholder="Nombre del archivo" required>
            </div>
            <div class="col-md-4">
                <input type="file" name="archivo" class="form-control" required>
            </div>
            <div class="col-md-4">
                <select name="contenido_id" class="form-select">
                    <option value="">Sin contenido</option>
                    @foreach($contenidos as $contenido)
                        <option value="{{ $contenido->id }}">{{ $contenido->titulo }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mt-3">
            <button class="btn btn-primary w-100">Subir Archivo</button>
        </div>
    </form>

    {{-- Tabla de archivos --}}
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Contenido</th>
                <th>Archivo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($archivos as $archivo)
            <tr>
                <td>{{ $archivo->nombre }}</td>
                <td>{{ strtoupper($archivo->tipo) }}</td>
                <td>{{ $archivo->contenido ? $archivo->contenido->titulo : 'Sin contenido' }}</td>
                <td>
                    <a href="{{ route('archivos.descargar', $archivo->id) }}" class="btn btn-sm btn-info">Ver / Descargar</a>
                </td>
                <td>
                    <form action="{{ route('archivos.borrar', $archivo->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este archivo?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
