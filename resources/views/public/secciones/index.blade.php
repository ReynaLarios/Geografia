@extends('public.layout')

@section('contenido')
<div class="container mt-4">

    <h2 class="mb-4 text-center">{{ $seccion->nombre }}</h2>

    @if($seccion->descripcion)
        <div class="mb-4 p-3 bg-light rounded shadow-sm">
          
        </div>
    @endif

    @if($seccion->imagen)
        <div class="mb-4 text-center">
            <img src="{{ asset('storage/'.$seccion->imagen) }}" class="img-fluid rounded shadow-sm" style="max-height: 300px; object-fit: cover;">
        </div>
    @endif

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
                                    <a href="{{ asset('storage/' . $cuadro->archivo) }}" target="_blank">
                                        {{ $cuadro->nombre_real }}
                                    </a>
                                    <small class="text-muted d-block">
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
    @else
        <p class="text-center text-muted">No hay cuadros disponibles.</p>
    @endif

    @if($seccion->archivos && $seccion->archivos->count())
        <div class="mb-4">
            <h5>Archivos adicionales</h5>
            <ul class="list-group">
                @foreach($seccion->archivos as $archivo)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="{{ asset('storage/' . $archivo->archivo) }}" target="_blank">
                            {{ $archivo->nombre_real }}
                        </a>
                        <small class="text-muted">
                            {{ number_format(Storage::disk('public')->size($archivo->archivo)/1024/1024, 2) }} MB
                        </small>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

</div>
@endsection

