@extends('public.layout')

@section('contenido')
<style>
    .cuadros-box {
        background: linear-gradient(135deg, #eef5ff, #ffffff);
        padding: 15px;
        border-radius: 12px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        border: 1px solid #d0e1ff;
        margin-bottom: 20px;
    }

    .table-cuadros thead {
        background: #dce9ff;
        color: #0b2f58;
    }

    .table-cuadros thead th {
        font-weight: 700;
    }

    .table-cuadros tbody tr:nth-child(even) {
        background: #f4f8ff;
    }

    .table-cuadros tbody tr:hover {
        background: #d7e7ff !important;
    }

    .table-cuadros td {
        vertical-align: middle;
    }

    .filter-dropdown {
        max-width: 200px;
        margin-bottom: 15px;
    }
</style>

<main class="container mt-4">

    <h2 class="mb-4 text-center">{{ $seccion->nombre }}</h2>

    @if($seccion->imagen)
    <div class="mb-4 text-center">
        <img src="{{ asset('storage/'.$seccion->imagen) }}" class="img-fluid rounded shadow-sm" style="max-height: 300px; object-fit: cover;">
    </div>
    @endif

    @if($seccion->descripcion)
    <div class="mb-4 p-3 bg-light rounded shadow-sm">
        {!! $seccion->descripcion !!}
    </div>
    @endif

    @if($seccion->cuadros && $seccion->cuadros->count())
    <div class="cuadros-box">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5>Cuadros</h5>

            {{-- Dropdown filtro --}}
            <select id="filter-letter" class="form-select form-select-sm filter-dropdown">
                <option value="all">Mostrar todos</option>
                @foreach(range('A','Z') as $letter)
                <option value="{{ $letter }}">{{ $letter }}</option>
                @endforeach
            </select>
        </div>

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
                        <a href="{{ asset('storage/' . $cuadro->archivo) }}" target="_blank">{{ $cuadro->nombre_real }}</a>
                        <small class="d-block text-muted">{{ number_format(Storage::disk('public')->size($cuadro->archivo)/1024/1024, 2) }} MB</small>
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

    @if($seccion->archivos && $seccion->archivos->count())
    <div class="mb-4">
        <h5>Archivos adicionales</h5>
        <ul class="list-group">
            @foreach($seccion->archivos as $archivo)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{ asset('storage/' . $archivo->archivo) }}" target="_blank">{{ $archivo->nombre_real }}</a>
                <small class="text-muted">{{ number_format(Storage::disk('public')->size($archivo->archivo)/1024/1024, 2) }} MB</small>
            </li>
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
        const select = document.getElementById('filter-letter');
        const items = document.querySelectorAll('.cuadro-item');

        select.addEventListener('change', function() {
            const value = select.value;
            items.forEach(item => {
                if (value === 'all' || item.dataset.letter === value) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection