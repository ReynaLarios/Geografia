@extends('base.layout')

@section('contenido')
<div class="container mt-4">
    <h2 class="mb-4 text-center">Archivos</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Tamaño</th>
                <th>Contenido</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($archivos as $archivo)
                <tr>
                    <td>{{ $archivo->nombre ?? 'Sin nombre' }}</td>
                    <td>{{ $archivo->tipo }}</td>
                    <td>
                        @if($archivo->ruta && Storage::disk('public')->exists($archivo->ruta))
                            {{ number_format(Storage::disk('public')->size($archivo->ruta) / 1024, 2) }} KB
                        @else
                            Archivo no disponible
                        @endif
                    </td>
                    <td>{{ $archivo->contenido->nombre ?? 'N/A' }}</td>
                    <td>
                        <form action="{{ route('archivos.borrar', $archivo->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
