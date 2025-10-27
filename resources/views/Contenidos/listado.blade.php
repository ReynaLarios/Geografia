@extends('base.layout')

@section('contenido')
<main>
    <h2 class="text-xl font-semibold mb-4">Listado de Contenidos</h2>

    <a href="{{ route('contenidos.crear') }}" class="fancy mb-3 d-inline-block">+ Agregar Contenido</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Título</th>
                <th>Sección</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contenidos as $contenido)
            <tr>
                <td>
                    <a href="{{ route('contenidos.mostrar', $contenido->id) }}">
                        {{ $contenido->titulo }}
                    </a>
                </td>
                <td>{{ $contenido->seccion->nombre ?? 'Sin sección' }}</td>
                <td class="d-flex gap-1">
                    <a href="{{ route('contenidos.editar', $contenido->id) }}" class="btn btn-sm btn-warning">✎</a>
                    <form action="{{ route('contenidos.borrar', $contenido->id) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres borrar este contenido?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">🗑</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</main>
@endsection
