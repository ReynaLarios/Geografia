@extends('public.layout')


@section('contenido')
<main class="p-4">

    <h2 class="text-xl font-semibold mb-4">Listado de Contenidos</h2>

    @if($contenidos->count() === 0)
        <p>No hay contenidos disponibles.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Sección</th>
                    <th>Ver más</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contenidos as $contenido)
                    <tr>
                        <td>{{ $contenido->titulo }}</td>
                        <td>{{ $contenido->seccion->nombre ?? 'Sin sección' }}</td>
                        <td>
                            <a href="{{ route('public.contenidos.show', $contenido->id) }}" class="btn btn-sm btn-primary">
    Ver
</a>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</main>
@endsection
