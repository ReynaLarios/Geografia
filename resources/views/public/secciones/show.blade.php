@extends('base.layout')

@section('contenido')
<style>
/* 🎨 Estilo Cuadros - Página pública */
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

/* Dropdown filtro */
#filter-dropdown {
    max-width: 200px;
    margin-bottom: 15px;
    border-radius: 8px;
    border: 1px solid #ffffff;
    background-color: #ffffff;
    color: #0d47a1;
    font-weight: 600;
}
#filter-dropdown option {
    color: #000000;
}
</style>

<main class="container mt-4">

    {{-- Nombre --}}
    <h2 class="mb-4 text-center">{{ $seccion->nombre }}</h2>

    {{-- Imagen --}}
    @if($seccion->imagen)
        <div class="mb-4 text-center">
            <img src="{{ asset('storage/'.$seccion->imagen) }}" class="img-fluid rounded shadow-sm" style="max-height: 300px; object-fit: cover;">
        </div>
    @endif

    {{-- Descripción --}}
    @if($seccion->descripcion)
        <div class="mb-4 p-3 bg-light rounded shadow-sm">
            <h5 class="mb-2">Descripción</h5>
            <div class="border p-2 rounded" style="min-height:100px;">
                {!! $seccion->descripcion !!}
            </div>
        </div>
    @endif

    {{-- Archivos --}}
    @if($seccion->archivos && count($seccion->archivos))
        <div class="mb-4">
            <h5>Archivos adicionales</h5>
            <ul class="list-group">
                @foreach($seccion->archivos as $archivo)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="{{ asset('storage/' . $archivo) }}" target="_blank">{{ basename($archivo) }}</a>
                        <small class="text-muted">
                            {{ number_format(Storage::disk('public')->size($archivo)/1024/1024, 2) }} MB
                        </small>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Cuadros --}}
    @if($seccion->cuadros && $seccion->cuadros->count())
        <div class="cuadros-box">
            

            {{-- Dropdown filtro --}}
            <select id="filter-dropdown" class="form-select form-select-sm">
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
                                @if($cuadro->archivo)
                                    <a href="{{ asset('storage/' . $cuadro->archivo) }}" target="_blank">Ver Archivo</a>
                                    <small class="text-muted">
                                        {{ number_format(Storage::disk('public')->size($cuadro->archivo)/1024/1024, 2) }} MB
                                    </small>
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

    {{-- Contenidos --}}
    @if($seccion->contenidosNavbar && $seccion->contenidosNavbar->count())
        <div class="mb-4">
            <h5>Contenidos asociados</h5>
            <ul class="list-group">
                @foreach($seccion->contenidosNavbar as $contenido)
                    <li class="list-group-item">{{ $contenido->titulo }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mt-3 text-center">
        <button class="btn btn-secondary" onclick="window.history.back()">← Regresar</button>
    </div>

</main>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropdown = document.getElementById('filter-dropdown');
    const cuadros = document.querySelectorAll('.cuadro-item');

    dropdown.addEventListener('change', function() {
        const val = this.value;
        cuadros.forEach(c => {
            if(val === 'all' || c.dataset.letter === val) {
                c.style.display = 'table-row';
            } else {
                c.style.display = 'none';
            }
        });
    });
});
</script>
@endsection
