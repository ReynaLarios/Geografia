@extends('base.layout')

@section('contenido')
<main class="container mt-4">

    {{-- Nombre de la sección --}}
    <h2 class="mb-4 text-center">{{ $seccion->nombre }}</h2>

    {{-- Imagen principal --}}
    @if($seccion->imagen)
        <div class="mb-4 text-center">
            <img src="{{ asset('storage/'.$seccion->imagen) }}" class="img-fluid rounded shadow-sm" style="max-height: 300px; object-fit: cover;">
        </div>
    @endif

    {{-- Descripción --}}
    @if($seccion->descripcion)
        <div class="mb-4 p-3 bg-light rounded shadow-sm">
            <h5 class="mb-2">Descripción</h5>
            <div class="border p-2 rounded" style="min-height:100px;">
                {!! $seccion->descripcion !!}
            </div>
        </div>
    @endif

    {{-- Archivos --}}
    @if($seccion->archivos && $seccion->archivos->count())
        <div class="mb-4">
            <h5>Archivos adicionales</h5>
            <ul class="list-group">
                @foreach($seccion->archivos as $archivo)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="{{ asset('storage/' . $archivo->archivo) }}" target="_blank">{{ $archivo->nombre_real }}</a>
                        <small class="text-muted">
                            {{ number_format(Storage::disk('public')->size($archivo->archivo)/1024/1024, 2) }} MB
                        </small>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Cuadros --}}
    @if($seccion->cuadros && $seccion->cuadros->count())
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
                            <td>{{ $cuadro->autor ?? '-' }}</td>
                            <td>
                                @if($cuadro->archivo)
                                    <a href="{{ asset('storage/' . $cuadro->archivo) }}" target="_blank">Ver archivo</a>
                                    <small class="text-muted">
                                        {{ number_format(Storage::disk('public')->size($cuadro->archivo)/1024/1024, 2) }} MB
                                    </small>
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
    @if($seccion->contenidos && $seccion->contenidos->count())
        <div class="mb-4">
            <h5>Contenidos asociados</h5>
            <ul class="list-group">
                @foreach($seccion->contenidos as $contenido)
                    <li class="list-group-item">{{ $contenido->titulo }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Botón regresar --}}
    <div class="mt-3 text-center">
        <button class="btn btn-secondary" onclick="window.history.back()">← Regresar</button>
    </div>

</main>
@endsection
