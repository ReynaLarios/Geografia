@extends('base.layout')

@section('contenido')
<main class="container mt-4">

    {{-- Nombre de la sección --}}
    <h2 class="mb-4 text-center">{{ $seccion->nombre }}</h2>

    {{-- Contenedor tipo panel para descripción --}}
    @if($seccion->descripcion)
        <div class="mb-4 p-3 bg-light rounded shadow-sm">
            <h5 class="mb-2">Descripción</h5>
            <div class="border p-2 rounded" style="min-height:100px;">
                {!! $seccion->descripcion !!}
            </div>
        </div>
    @endif

    {{-- Imagen principal --}}
    @if($seccion->imagen)
        <div class="mb-4">
            <h5>Imagen principal</h5>
            <div class="border p-2 rounded text-center">
                <img src="{{ asset('storage/' . $seccion->imagen) }}" class="img-fluid rounded" alt="Imagen de la sección">
            </div>
        </div>
    @endif

    {{-- Archivos adicionales --}}
    @if($seccion->archivos && count($seccion->archivos) > 0)
        <div class="mb-4">
            <h5>Archivos adicionales</h5>
            <ul class="list-group">
                @foreach($seccion->archivos as $archivo)
                    <li class="list-group-item"><a href="{{ asset('storage/' . $archivo) }}" target="_blank">{{ basename($archivo) }}</a></li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Cuadros --}}
    @if($seccion->cuadros && $seccion->cuadros->count() > 0)
        <div class="mb-4">
            <h5>Cuadros</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Archivo</th>
                        <th>Mostrar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($seccion->cuadros as $cuadro)
                        <tr>
                            <td>{{ $cuadro->titulo }}</td>
                            <td>{{ $cuadro->autor }}</td>
                            <td>
                                @if($cuadro->archivo)
                                    <a href="{{ asset('storage/' . $cuadro->archivo) }}" target="_blank">Ver archivo</a>
                                @else
                                    <span class="text-muted">Sin archivo</span>
                                @endif
                            </td>
                            <td class="text-center">{{ $cuadro->mostrar ? 'Sí' : 'No' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    {{-- Contenidos asociados --}}
    @if($seccion->contenidos && $seccion->contenidos->count() > 0)
        <div class="mb-4">
            <h5>Contenidos asociados</h5>
            <ul class="list-group">
                @foreach($seccion->contenidos as $contenido)
                    <li class="list-group-item">{{ $contenido->titulo }}</li>
                @endforeach
            </ul>
        </div>
    @endif

</main>
@endsection
