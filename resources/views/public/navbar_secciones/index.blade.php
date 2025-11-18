@extends('public.layout')


@section('contenido')
<div class="container mt-4">
    <h2 class="mb-4 text-center">Listado de Secciones</h2>

    {{-- SIN BOTÓN DE AGREGAR SECCIÓN --}}

    <table class="table table-bordered align-middle text-center">
        <thead class="table-light">
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Ver</th>
            </tr>
        </thead>
        <tbody>
            @foreach($secciones as $seccion)
            <tr>
                <td>{{ $seccion->nombre }}</td>
                <td>{{ Str::limit($seccion->descripcion, 80) }}</td>
                <td>
                    <a href="{{ route('public.navbar.secciones.mostrar', $seccion->id) }}"
                       class="btn btn-info btn-sm">👁️ Ver</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
