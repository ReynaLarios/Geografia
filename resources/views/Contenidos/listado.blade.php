@extends('base.layout')

@section('contenido')
<main class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold" style="letter-spacing:.5px;">Listado de Contenidos</h2>

        <a href="{{ route('contenidos.crear') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
            + Agregar Contenido
        </a>
    </div>

    {{-- Mensajes --}}
    @if(session('success'))
        <div class="alert alert-success shadow-sm rounded-3">{{ session('success') }}</div>
    @endif

    {{-- Tabla --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">

            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="py-3">Título</th>
                        <th class="py-3">Sección</th>
                        <th class="py-3 text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($contenidos as $contenido)
                        <tr>
                            <td class="fw-semibold">
                                <a href="{{ route('contenidos.mostrar', $contenido->id) }}"
                                   class="text-decoration-none text-primary hover-text">
                                    {{ $contenido->titulo }}
                                </a>
                            </td>

                            <td class="text-muted">
                                {{ $contenido->seccion->nombre ?? 'Sin sección' }}
                            </td>

                            <td class="text-center">
                                <div class="d-inline-flex gap-2">

                                    {{-- Editar --}}
                                    <a href="{{ route('contenidos.editar', $contenido->id) }}"
                                       class="btn btn-outline-warning btn-sm rounded-pill px-3 shadow-sm">
                                        Editar
                                    </a>

                                    {{-- Borrar --}}
                                    <form action="{{ route('contenidos.borrar', $contenido->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('¿Seguro que quieres borrar este contenido?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm rounded-pill px-3 shadow-sm">
                                            Eliminar
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-muted fs-5">
                                No hay contenidos registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>

</main>

{{-- Estilos extras para hacer todo más elegante --}}
<style>
    .hover-text:hover {
        color: #0a58ca !important;
        text-decoration: underline !important;
    }

    table tbody tr:hover {
        background-color: #f8f9fa;
    }
</style>

@endsection
