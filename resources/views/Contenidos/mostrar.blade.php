@extends('base.layout')

@section('contenido')
<style>
/* 🎨 Estilo Contenidos */
.contenidos-box {
    background: linear-gradient(135deg, #eef5ff, #ffffff);
    padding: 20px;
    border-radius: 14px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.12);
    margin-top: 20px;
    border: 1px solid #d0e1ff;
}

.contenidos-box h5 {
    color: #0d3b66;
    font-weight: bold;
    margin-bottom: 15px;
}

.table-contenidos thead {
    background: #dce9ff;
    color: #0b2f58;
}

.table-contenidos thead th {
    padding: 14px;
    font-size: 15px;
    font-weight: 700;
    border-bottom: 2px solid #9ec3ff !important;
}

.table-contenidos tbody tr {
    background: #ffffff;
    transition: background 0.25s ease, transform 0.2s ease;
}

.table-contenidos tbody tr:nth-child(even) {
    background: #f4f8ff;
}

.table-contenidos tbody tr:hover {
    background: #d7e7ff !important;
    transform: scale(1.01);
    box-shadow: 0 2px 6px rgba(0,0,0,0.10);
}

.table-contenidos td {
    padding: 12px;
    vertical-align: middle;
    color: #1a1a1a;
}

.table-contenidos a {
    color: #0d47a1;
    font-weight: 600;
}

.table-contenidos a:hover {
    text-decoration: underline;
}

.table-contenidos small {
    color: #555;
}

#filter-dropdown {
    max-width: 200px;
    margin-bottom: 15px;
}
</style>

<main class="container mt-4">

    <h2 class="mb-4 text-center">{{ $contenido->titulo }}</h2>

    @if($contenido->imagen)
        <div class="mb-4 text-center">
            <img src="{{ asset('storage/'.$contenido->imagen) }}" class="img-fluid rounded shadow-sm" style="max-height: 300px; object-fit: cover;">
        </div>
    @endif

    @if($contenido->descripcion)
        <div class="mb-4 p-3 bg-light rounded shadow-sm">
            <div class="border p-2 rounded" style="min-height:100px;">
                {!! $contenido->descripcion !!}
            </div>
        </div>
    @endif

    {{-- Archivos asociados --}}
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

    {{-- Detalles del contenido --}}
    @if($contenido->detalles && $contenido->detalles->count())
        <div class="contenidos-box">
            <h5>Detalles</h5>

            <select id="filter-dropdown" class="form-select form-select-sm mb-2">
                <option value="all">Todos</option>
                @foreach(range('A','Z') as $letter)
                    <option value="{{ $letter }}">{{ $letter }}</option>
                @endforeach
            </select>

            <table class="table table-contenidos">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Archivo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contenido->detalles->sortBy('titulo') as $detalle)
                        <tr class="detalle-item" data-letter="{{ strtoupper(substr($detalle->titulo,0,1)) }}">
                            <td>{{ $detalle->titulo }}</td>
                            <td>{{ $detalle->autor ?? '-' }}</td>
                            <td>
                                @if($detalle->archivos && $detalle->archivos->count())
                                    @foreach($detalle->archivos as $archivo)
                                        <a href="{{ asset('storage/' . $archivo->ruta) }}" target="_blank">Ver archivo</a>
                                        <small class="text-muted">
                                            @if($archivo->ruta && Storage::disk('public')->exists($archivo->ruta))
                                                {{ number_format(Storage::disk('public')->size($archivo->ruta)/1024/1024, 2) }} MB
                                            @else
                                                0 MB
                                            @endif
                                        </small>
                                    @endforeach
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
        <button class="fancy" onclick="window.history.back()">← Regresar</button>
    </div>
</main>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropdown = document.getElementById('filter-dropdown');
    const detalles = document.querySelectorAll('.detalle-item');

    dropdown.addEventListener('change', function() {
        const val = this.value;
        detalles.forEach(d => {
            if(val === 'all' || d.dataset.letter === val) {
                d.style.display = 'table-row';
            } else {
                d.style.display = 'none';
            }
        });
    });
});
</script>
@endsection
