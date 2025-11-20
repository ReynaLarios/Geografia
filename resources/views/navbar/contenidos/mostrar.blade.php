@extends('base.layout')

@section('contenido')
<style>
/* 🎨 Estilo Cuadros */
.cuadros-box {
    background: linear-gradient(135deg, #eef5ff, #ffffff);
    padding: 20px;
    border-radius: 14px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.12);
    margin-top: 20px;
    border: 1px solid #d0e1ff;
}

.cuadros-box h5 {
    color: #0d3b66;
    font-weight: bold;
    margin-bottom: 15px;
}

.table-cuadros thead {
    background: #dce9ff;
    color: #0b2f58;
}

.table-cuadros thead th {
    padding: 14px;
    font-size: 15px;
    font-weight: 700;
    border-bottom: 2px solid #9ec3ff !important;
}

.table-cuadros tbody tr {
    background: #ffffff;
    transition: background 0.25s ease, transform 0.2s ease;
}

.table-cuadros tbody tr:nth-child(even) {
    background: #f4f8ff;
}

.table-cuadros tbody tr:hover {
    background: #d7e7ff !important;
    transform: scale(1.01);
    box-shadow: 0 2px 6px rgba(0,0,0,0.10);
}

.table-cuadros td {
    padding: 12px;
    vertical-align: middle;
    color: #1a1a1a;
}

.table-cuadros a {
    color: #0d47a1;
    font-weight: 600;
}

.table-cuadros a:hover {
    text-decoration: underline;
}

.table-cuadros small {
    color: #555;
}
</style>

<main class="container mt-4">

    <h2 class="mb-4 text-center">{{ $contenido->titulo }}</h2>

    {{-- Imagen principal --}}
    @if($contenido->imagen)
        <div class="mb-4 text-center">
            <img src="{{ asset('storage/'.$contenido->imagen) }}" class="img-fluid rounded shadow-sm" style="max-height: 300px; object-fit: cover;">
        </div>
    @endif

    {{-- Descripción --}}
    @if($contenido->descripcion)
        <div class="mb-4 p-3 bg-light rounded shadow-sm">
            {!! $contenido->descripcion !!}
        </div>
    @endif

    {{-- Archivos --}}
    @if($contenido->archivos && count($contenido->archivos) > 0)
        <div class="mb-4">
            <h5>Archivos adjuntos:</h5>
            <ul>
                @foreach($contenido->archivos as $archivo)
                    <li>
                        <a href="{{ asset('storage/' . $archivo) }}" target="_blank">
                            {{ basename($archivo) }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Cuadros --}}
    @if($contenido->cuadros && count($contenido->cuadros) > 0)
        <div class="cuadros-box">
            <h5>Cuadros</h5>
            <table class="table table-cuadros">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Archivo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contenido->cuadros->sortBy('titulo') as $cuadro)
                        <tr>
                            <td>{{ $cuadro->titulo }}</td>
                            <td>{{ $cuadro->autor ?? '-' }}</td>
                            <td>
                                @if($cuadro->archivo)
                                    <a href="{{ asset('storage/' . $cuadro->archivo) }}" target="_blank">Ver archivo</a>
                                    <small>{{ number_format(Storage::disk('public')->size($cuadro->archivo)/1024/1024,2) }} MB</small>
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

    <div class="mt-3 text-center">
        <button class="btn btn-secondary" onclick="window.history.back()">← Regresar</button>
    </div>

</main>
@endsection
