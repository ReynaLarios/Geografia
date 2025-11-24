@extends('base.layout')

@section('contenido')
<div class="container mt-4">
    <h2 class="mb-4 text-center" style="color: var(--azul-oscuro);">
        Listado de Contenidos Navbar
    </h2>

    <button class="fancy mb-3" onclick="window.location='{{ route('navbar.contenidos.crear') }}'">
        + Agregar Contenido
    </button>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Título</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($contenidos as $contenido)
                <tr>
                    <td>{{ $contenido->titulo }}</td>


                    </td>

                    <td class="d-flex gap-1">
                        <a href="{{ route('navbar.contenidos.mostrar', $contenido->id) }}" 
                           class="fancy">👁</a>

                        <a href="{{ route('navbar.contenidos.editar', $contenido->id) }}" 
                           class="fancy">✎</a>

                        <form action="{{ route('navbar.contenidos.borrar', $contenido->id) }}" 
                              method="POST" onsubmit="return confirm('¿Seguro que deseas borrar este contenido?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="fancy btn-borrar">🗑</button>
                        </form>
                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="3" class="text-center text-muted">
                        No hay contenidos registrados aún.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
