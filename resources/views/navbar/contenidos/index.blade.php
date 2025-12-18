@extends('base.layout')

@section('contenido')
<div class="container mt-4">
    <h2 class="mb-4 text-center" style="color: var(--azul-oscuro);">
        Listado de Contenidos Navbar
    </h2>

    <button class="btn btn-primary mb-3" onclick="window.location='{{ route('navbar.contenidos.crear') }}'">
        + Agregar Contenido
    </button>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <style>
        .btn-accion {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 32px;
            width: 32px;
            padding: 0;
            font-size: 16px;
            border-radius: 6px;
        }
        .btn-accion:hover {
            transform: scale(1.1);
        }
        .acciones-flex {
            display: flex;
            gap: 6px;
            align-items: center;
        }
    </style>

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Título</th>
                <th style="width: 120px;">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($contenidos as $contenido)
                <tr>
                    <td>{{ $contenido->titulo }}</td>

                    <td>
                        <div class="acciones-flex">

                            <a href="{{ route('navbar.contenidos.mostrar', $contenido->slug) }}" 
                               class="btn btn-secondary btn-accion">Ver</a>

                            <a href="{{ route('navbar.contenidos.editar', $contenido->slug) }}" 
                               class="btn btn-warning btn-accion">✎</a>

                            <form action="{{ route('navbar.contenidos.borrar', $contenido->slug) }}" 
                                  method="POST"
                                  onsubmit="return confirm('¿Seguro que deseas borrar este contenido?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-accion">🗑</button>
                            </form>

                        </div>
                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="2" class="text-center text-muted">
                        No hay contenidos registrados aún.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
