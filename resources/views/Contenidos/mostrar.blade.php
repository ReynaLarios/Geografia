@extends('base.layout')

@section('contenido')
<main class="p-4" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">

    <h2 class="mb-3">{{ $contenido->titulo }}</h2>

    {{-- Imagen principal --}}
    @if($contenido->imagen)
        <div class="mb-3">
            <img src="{{ asset('storage/'.$contenido->imagen) }}" alt="{{ $contenido->titulo }}" 
                 style="max-width: 250px; border-radius: 8px;">
        </div>
    @endif

    {{-- Descripción --}}
    <div class="mb-3">
        <div class="contenido-descripcion">
            {!! $contenido->descripcion !!}
        </div>
    </div>

    {{-- Archivos asociados --}}
    @if($contenido->archivos && $contenido->archivos->count() > 0)
        <div class="card mt-3 shadow-sm mx-auto" style="width: 100%; max-width: 800px; border-radius: 6px;">
            <div class="card-header bg-primary text-white p-2">
                <h6 class="mb-0">Archivos asociados</h6>
            </div>
            <div class="card-body p-2">
                <ul class="list-unstyled mb-0">
                    @foreach($contenido->archivos as $archivo)
                        <li style="margin-bottom: 6px;">
                            <a href="{{ asset('storage/'.$archivo->ruta) }}" download
                               style="text-decoration: none; color: #007bff; font-size: 0.95em;">
                                📎 {{ $archivo->nombre }}
                                <span class="text-muted" style="font-size: 0.8em;">
                                    @if(Storage::disk('public')->exists($archivo->ruta))
                                        ({{ round(Storage::disk('public')->size($archivo->ruta) / 1024 / 1024, 2) }} MB)
                                    @else
                                        (archivo no disponible)
                                    @endif
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- Cuadros tipo tabla --}}
    @if($contenido->cuadros && $contenido->cuadros->count() > 0)
        <div class="card mt-4 shadow-sm mx-auto" style="width: 100%; max-width: 800px; border-radius: 6px;">
            <div class="card-header bg-primary text-white p-2">
                <h6 class="mb-0">Cuadros</h6>
            </div>
            <div class="card-body p-2">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Archivo</th>
                            <th>Visible</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contenido->cuadros as $cuadro)
                            <tr @if(!$cuadro->mostrar) class="table-secondary" @endif>
                                <td>{{ $cuadro->titulo }}</td>
                                <td>{{ $cuadro->autor }}</td>
                                <td>
                                    @if($cuadro->archivo)
                                        <a href="{{ asset('storage/'.$cuadro->archivo) }}" target="_blank">📎 Ver archivo</a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($cuadro->mostrar)
                                        ✅
                                    @else
                                        ❌
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <p class="text-muted mt-2">No hay cuadros asociados a este contenido.</p>
    @endif

</main>
@endsection
