@extends('base.layout')

@section('contenido')
<main class="p-4" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">

    <h2>{{ $contenido->titulo }}</h2>
    <p>{!! $contenido->descripcion !!}</p>

    @if($contenido->imagen)
        <div class="mb-3">
            <img src="{{ asset('storage/'.$contenido->imagen) }}" class="img-fluid rounded">
        </div>
    @endif

    {{-- Cuadro tipo tabla --}}
    @if($contenido->cuadros->isNotEmpty())
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
                                <a href="{{ asset('storage/'.$cuadro->archivo) }}" download>{{ $nombreArchivo }}</a>
                                ({{ $tamanoMB }} MB)
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
