@extends('base.layout')

@section('contenido')
<main class="container mt-4">

    <h2 class="mb-4 text-center">{{ $contenido->titulo }}</h2>

    @if($contenido->imagen)
        <div class="mb-4 text-center">
            <img src="{{ asset('storage/'.$contenido->imagen) }}" class="img-fluid rounded shadow-sm" style="max-height: 300px; object-fit: cover;">
        </div>
    @endif

    @if($contenido->descripcion)
        <div class="mb-4 p-3 bg-light rounded shadow-sm">
            {!! $contenido->descripcion !!}
        </div>
    @endif

    @if($contenido->archivos && $contenido->archivos->count())
        <div class="mb-4">
            <h5>Archivos asociados</h5>
            <ul class="list-group">
                @foreach($contenido->archivos as $archivo)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="{{ asset('storage/' . $archivo->ruta) }}" target="_blank">{{ $archivo->nombre }}</a>
                        <small class="text-muted">
                            @if($archivo->ruta && Storage::disk('public')->exists($archivo->ruta))
                                {{ number_format(Storage::disk('public')->size($archivo->ruta)/1024/1024, 2) }} MB
                            @else
                                0 MB
                            @endif
                        </small>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($contenido->cuadros && $contenido->cuadros->count())
        <div class="mb-4 p-3 bg-light rounded shadow-sm">
            <h5>Cuadros</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Archivo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contenido->cuadros as $cuadro)
                    <tr>
                        <td>{{ $cuadro->titulo }}</td>
                        <td>{{ $cuadro->autor ?? '-' }}</td>
                        <td>
                            @if($cuadro->archivo && Storage::disk('public')->exists($cuadro->archivo))
                                <a href="{{ asset('storage/'.$cuadro->archivo) }}" target="_blank">Ver archivo</a>
                            @else
                                <span class="text-muted">Sin archivo</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="mt-3">
        <button class="btn btn-outline-secondary" onclick="window.history.back()">← Regresar</button>
    </div>
</main>
@endsection
