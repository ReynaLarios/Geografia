@extends('public.layout')

@section('contenido')
<style>
.cuadros-box {
    background: #f8faff;
    padding: 15px;
    border-radius: 10px;
    border: 1px solid #d0e1ff;
    margin-top: 20px;
}
.cuadros-box h5 {
    color: #0d3b66;
    font-weight: 600;
    margin-bottom: 10px;
}
.table-cuadros thead {
    background: #dce9ff;
    color: #0b2f58;
}
.table-cuadros thead th {
    padding: 10px;
    font-weight: 600;
}
.table-cuadros tbody td {
    padding: 10px;
    color: #1a1a1a;
}
.table-cuadros tbody tr:nth-child(even) {
    background: #edf5ff;
}
.table-cuadros a {
    color: #0d47a1;
    font-weight: 500;
}
.table-cuadros a:hover {
    text-decoration: underline;
}
#filter-dropdown {
    max-width: 180px;
    margin-bottom: 15px;
    background-color: #ffffff;
    color: #0d3b66;
    border: 1px solid #0d3b66;
}
</style>

<main class="container mt-4">

    <h2 class="mb-4 text-center">{{ $seccion->nombre }}</h2>

    @if($seccion->imagen)
        <div class="mb-4 text-center">
            <img src="{{ asset('storage/'.$seccion->imagen) }}" class="img-fluid rounded shadow-sm" style="max-height: 300px; object-fit: cover;">
        </div>
    @endif

    @if(!empty($seccion->descripcion))
        <div class="mb-4 p-3 bg-light rounded shadow-sm">
            {!! $seccion->descripcion !!}
        </div>
    @endif

    <!-- Archivos adicionales -->
    @if($seccion->archivos && $seccion->archivos->count())
        <div class="mb-4">
            <h5>Archivos adicionales</h5>
            <ul class="list-group">
                @foreach($seccion->archivos as $archivo)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="{{ asset('storage/' . $archivo->ruta) }}" target="_blank">{{ $archivo->nombre }}</a>
                        <small class="text-muted">{{ number_format(Storage::disk('public')->size($archivo->ruta)/1024/1024, 2) }} MB</small>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

  @if($seccion->cuadros->isNotEmpty())
    <div class="cuadros-box">

        <select id="filter-dropdown" class="form-select form-select-sm mb-2">
            <option value="all">Todos</option>
            @foreach(range('A','Z') as $letter)
                <option value="{{ $letter }}">{{ $letter }}</option>
            @endforeach
        </select>

        <table class="table table-cuadros">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Archivo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($seccion->cuadros->sortBy('titulo') as $cuadro)
                    <tr class="cuadro-item" data-letter="{{ strtoupper(substr($cuadro->titulo,0,1)) }}">
                        <td>{{ $cuadro->titulo }}</td>
                        <td>{{ $cuadro->autor ?? '-' }}</td>
                        <td>
                            @if($cuadro->archivos->isNotEmpty())
                                @foreach($cuadro->archivos as $archivo)
                                    <a href="{{ asset('storage/' . $archivo->ruta) }}" target="_blank">Ver archivo</a>
                                @endforeach
                            @else
                                <span class="text-muted">-</span>
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

@endsection
