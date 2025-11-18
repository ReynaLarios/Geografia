@extends('public.layout')


@section('contenido')
<main class="p-4"
      style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">

    <h2 class="mb-3">{{ $contenido->titulo }}</h2>

    <div class="mb-3">
        {!! $contenido->descripcion !!}
    </div>

    @if($contenido->imagen)
        <div class="mb-4">
            <img src="{{ asset('storage/'.$contenido->imagen) }}" class="img-fluid rounded">
        </div>
    @endif

    {{-- Cuadros asociados como tabla --}}
    @if($contenido->cuadros->isNotEmpty())
        <h4 class="mt-4 mb-3">Archivos relacionados</h4>

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
                        <td>{{ $cuadro->autor }}</td>

                        <td>
                            @if($cuadro->archivo)
                                @php
                                    $tamano = Storage::disk('public')->size($cuadro->archivo);
                                    $tamanoMB = number_format($tamano / 1024 / 1024, 2);
                                    $nombreArchivo = basename($cuadro->archivo);
                                @endphp

                                <a href="{{ asset('storage/'.$cuadro->archivo) }}" download>
                                    {{ $nombreArchivo }}
                                </a>

                                <small class="text-muted">
                                    ({{ $tamanoMB }} MB)
                                </small>
                            @else
                                —
                            @endif
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</main>
@endsection
