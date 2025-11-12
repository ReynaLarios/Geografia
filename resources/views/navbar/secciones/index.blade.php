@extends('base.layout')

@section('contenido')
<div class="container mt-4">
    <h2 class="mb-4">Secciones del Navbar</h2>

    <a href="{{ route('navbar.secciones.crear') }}" class="btn btn-primary mb-3">+ Nueva Sección</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción corta</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($secciones as $sec)
                <tr>
                    <td>{{ $sec->nombre }}</td>
                    <td>{!! Str::limit(strip_tags($sec->descripcion), 70) !!}</td>

                    <td>
                        @if($sec->imagen)
                            <img src="{{ asset('storage/'.$sec->imagen) }}" width="70">
                        @else
                            <span class="text-muted">Sin imagen</span>
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('navbar.secciones.mostrar', $sec->id) }}" class="btn btn-info btn-sm">Ver</a>
                        <a href="{{ route('navbar.secciones.editar', $sec->id) }}" class="btn btn-warning btn-sm">Editar</a>

                        <form action="{{ route('borrarSeccion', $sec->id) }}"
                              method="POST" class="d-inline">
                              @csrf @method('DELETE')
                              <button class="btn btn-danger btn-sm" 
                                      onclick="return confirm('¿borrar sección?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted">No hay secciones registradas</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
