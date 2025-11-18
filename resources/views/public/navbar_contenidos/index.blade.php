@extends('public.layout')


@section('contenido')
<div class="container mt-4">
    <h2 class="mb-4 text-center" style="color: var(--azul-oscuro);">
        Contenidos del Navbar
    </h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Título</th>
                <th>Sección</th>
                <th>Ver</th>
            </tr>
        </thead>
        <tbody>
            @foreach($navbarContenidos ?? [] as $contenido)
                <tr>
                    <td>{{ $contenido->nombre }}</td>
                    <td>{{ $contenido->seccion->nombre ?? 'Sin sección' }}</td>
                    <td class="text-center">
                        <a href="{{ route('public.navbar.contenidos.mostrar', $contenido->id) }}" class="fancy">
                            👁 Ver
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
