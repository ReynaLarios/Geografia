@extends('base.layout')

@section('contenido')
<div class="container mt-4">

    <h2 class="mb-4 text-center" style="color: var(--azul-oscuro);">
        Listado de Nav Horizontal 
    </h2>

    <button class="btn btn-primary mb-3"
        onclick="window.location='{{ route('navbar.secciones.crear') }}'">
        + Agregar Sección
    </button>

    @if (session('ok'))
        <div class="alert alert-success">
            {{ session('ok') }}
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
                <th>Nombre</th>
                <th style="width: 120px;">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($navbarSecciones as $seccion)
                <tr>
                    <td>{{ $seccion->nombre }}</td>

                    <td>
                        <div class="acciones-flex">

                            <a href="{{ route('navbar.secciones.mostrar', $seccion->slug) }}"
                               class="btn btn-secondary btn-accion">Ver</a>

                            <a href="{{ route('navbar.secciones.editar', $seccion->slug) }}"
                               class="btn btn-warning btn-accion">✎</a>

                            <form action="{{ route('navbar.secciones.borrar', $seccion->slug) }}"
                                  method="POST"
                                  onsubmit="return confirm('¿Seguro que deseas borrar esta sección?');">
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
                        No hay secciones registradas aún.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>
@endsection
