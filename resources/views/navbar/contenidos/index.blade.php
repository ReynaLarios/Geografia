@extends('base.layout')

@section('contenido')
<div class="container mt-4">
    <h2 class="mb-4 text-center" style="color: var(--azul-oscuro);">Listado de Contenidos Navbar</h2>

    <button class="fancy mb-3" onclick="window.location='{{ route('navbar.contenidos.crear') }}'">
        + Agregar Contenido
    </button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Título</th>
                <th>Sección</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($navbarContenidos ?? [] as $contenido)
                <tr>
                    <td>{{ $contenido->nombre }}</td>
                    <td>{{ $contenido->seccion->nombre ?? 'Sin sección' }}</td>
                    <td class="d-flex gap-1">
                        <a href="{{ route('navbar.contenidos.mostrar', $contenido->id) }}" class="fancy">👁</a>
                        <a href="{{ route('navbar.contenidos.editar', $contenido->id) }}" class="fancy">✎</a>
                        <form action="{{ route('navbar.contenidos.borrar', $contenido->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="fancy btn-borrar">🗑</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
