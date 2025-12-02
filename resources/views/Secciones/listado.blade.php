@extends('base.layout')

@section('contenido')
<div class="container mt-4">

    <h2 class="mb-4 text-center" style="color: var(--azul-oscuro);">
        Listado de Secciones
    </h2>

    <button class="btn btn-primary mb-3"
        onclick="window.location='{{ route('secciones.crear') }}'">
        + Crear Sección
    </button>

    @if(session('ok'))
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

    @if($secciones && $secciones->count() > 0)

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Cuadros</th>
                <th style="width: 120px;">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach($secciones as $seccion)
                <tr>
                    <td>{{ $seccion->nombre }}</td>

                    <td>
                        {{ Str::limit($seccion->descripcion, 80) ?? 'Sin descripción' }}
                    </td>

                    <td>
                        {{ $seccion->cuadros && $seccion->cuadros->count() > 0
                            ? $seccion->cuadros->count() . ' cuadros'
                            : 'Sin cuadros' }}
                    </td>

                    <td>
                        <div class="acciones-flex">

                            {{-- Ver --}}
                            <a href="{{ route('secciones.mostrar', $seccion->slug) }}"
                               class="btn btn-secondary btn-accion">Ver</a>

                            {{-- Editar --}}
                            <a href="{{ route('secciones.editar', $seccion->slug) }}"
                               class="btn btn-warning btn-accion">✎</a>

                            {{-- Borrar --}}
                            <form action="{{ route('secciones.borrar', $seccion->slug) }}"
                                  method="POST"
                                  onsubmit="return confirm('¿Seguro que deseas borrar esta sección?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-accion">🗑</button>
                            </form>

                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @else
        <div class="text-center mt-5">
            <p class="text-muted fs-5">No hay secciones registradas.</p>
        </div>
    @endif

</div>
@endsection
