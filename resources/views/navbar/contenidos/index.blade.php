@extends('base.layout')

@section('contenido')
<div class="container mt-4">

    <h2 class="mb-3"><strong>Contenidos del Navbar</strong></h2>

    <a href="{{ route('navbar.contenidos.crear') }}" class="btn btn-primary mb-3">+ Agregar Contenido</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Título</th>
                <th>Sección</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach($contenidos as $contenido)
            <tr>
                <td>{{ $contenido->titulo }}</td>

                <td>{{ $contenido->seccion->nombre }}</td>

                <td>
                    @if($contenido->imagen)
                        <img src="{{ asset('storage/' . $contenido->imagen) }}"
                             width="60" class="rounded">
                    @else
                        —
                    @endif
                </td>

                <td>
                    <a href="{{ route('navbar.contenidos.mostrar', $contenido->id) }}" class="btn btn-info btn-sm">Ver</a>
                    <a href="{{ route('navbar.contenidos.editar', $contenido->id) }}" class="btn btn-warning btn-sm">Editar</a>

                    <form action="{{ route('navbar.contenidos.eliminar', $contenido->id) }}"
                          method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Borrar</button>
                    </form>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
