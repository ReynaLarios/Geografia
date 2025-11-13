@extends('base.layout')

@section('contenido')
<div class="container mt-4">

    <h2 class="mb-4 text-center" style="color: var(--azul-oscuro);">
        <strong>{{ $contenido->titulo }}</strong>
    </h2>

    @if(!empty($contenido->imagen) && file_exists(storage('app/public/' . $contenido->imagen)))
        <div class="text-center mb-4">
            <img src="{{ asset('storage/' . $contenido->imagen) }}" alt="Imagen principal" class="img-fluid rounded shadow-sm" style="max-height: 400px;">
        </div>
    @endif


    @if(!empty($contenido->descripcion))
        <div class="mb-4 p-3 rounded" style="background: var(--azul-suave); color: var(--azul-oscuro);">
            {!! nl2br(e($contenido->descripcion)) !!}
        </div>
    @endif


    @if($contenido->archivos && count($contenido->archivos) > 0)
        <div class="mb-4">
            <h5>Archivos adjuntos:</h5>
            <ul>
                @foreach($contenido->archivos as $archivo)
                    <li>
                        <a href="{{ asset('storage/' . $archivo) }}" target="_blank" class="fancy" style="display:inline-block; padding:5px 10px; margin:3px;">
                            {{ basename($archivo) }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Cuadros tipo tabla --}}
    @if($contenido->cuadros && count($contenido->cuadros) > 0)
        <div class="mb-4">
            <h5>Cuadro tipo tabla</h5>
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
                    @foreach($contenido->cuadros as $cuadro)
                        <tr>
                            <td>{{ $cuadro->titulo }}</td>
                            <td>{{ $cuadro->autor }}</td>
                            <td>
                                @if(!empty($cuadro->archivo) && file_exists(storage_path('app/public/' . $cuadro->archivo)))
                                    <a href="{{ asset('storage/' . $cuadro->archivo) }}" target="_blank" class="fancy btn-sm">Ver archivo</a>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($cuadro->mostrar)
                                    ✔
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="mt-3">
        <button class="fancy" onclick="window.history.back()">← Regresar</button>
    </div>

</div>
@endsection

