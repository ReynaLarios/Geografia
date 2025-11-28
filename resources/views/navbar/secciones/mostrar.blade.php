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
.cuadros-box h5 { color: #0d3b66; font-weight: bold; margin-bottom: 15px; }
.table-cuadros thead { background: #dce9ff; color: #0b2f58; }
.table-cuadros td { padding: 12px; vertical-align: middle; }
.table-cuadros a { color: #0d47a1; font-weight: 600; }
.table-cuadros a:hover { text-decoration: underline; }
</style>

<main class="container mt-4">

    <h2 class="mb-4 text-center">{{ $seccion->nombre }}</h2>

    {{-- Imagen principal --}}
    @if($seccion->imagen)
        <div class="mb-4 text-center">
            <img src="{{ asset('storage/'.$seccion->imagen) }}" class="img-fluid rounded shadow-sm" style="max-height:300px; object-fit:cover;">
        </div>
    @endif

    {{-- Descripción --}}
    @if($seccion->descripcion)
        <div class="mb-4 p-3 bg-light rounded shadow-sm">{!! $seccion->descripcion !!}</div>
    @endif

    {{-- Archivos adicionales --}}
    @if($seccion->archivos?->count())
        <div class="mb-4">
            <h5>Archivos adicionales</h5>
            <ul class="list-group">
                @foreach($seccion->archivos as $archivo)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="{{ asset('storage/' . $archivo->ruta) }}" target="_blank">{{ $archivo->nombre }}</a>
                        <small class="text-muted">{{ number_format(Storage::disk('public')->size($archivo->ruta)/1024/1024,2) }} MB</small>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Cuadros --}}
    @if($seccion->cuadros?->count())
        <div class="cuadros-box">
            <h5>Cuadros</h5>
            <table class="table table-cuadros">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Archivo principal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($seccion->cuadros->sortBy('titulo') as $cuadro)
                        <tr>
                            <td>{{ $cuadro->titulo }}</td>
                            <td>{{ $cuadro->autor ?? '-' }}</td>
                            <td>
                                @if($cuadro->ruta)
                                    <a href="{{ asset('storage/' . $cuadro->ruta) }}" target="_blank">Ver archivo</a>
                                    <small class="text-muted">{{ number_format(Storage::disk('public')->size($cuadro->ruta)/1024/1024,2) }} MB</small>
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

    {{-- Botón regresar --}}
    <div class="mt-3">
        <button class="fancy" onclick="window.history.back()">← Regresar</button>
    </div>

</main>
@endsection
