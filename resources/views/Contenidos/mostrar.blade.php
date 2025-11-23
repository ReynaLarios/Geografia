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

.table-cuadros tbody tr:nth-child(even) {
    background: #f4f8ff;
}

.table-cuadros tbody tr:hover {
    background: #d7e7ff !important;
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

.table-cuadros small {
    color: #555;
}

#filter-dropdown {
    max-width: 200px;
    margin-bottom: 15px;
}
</style>

<main class="p-4" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
    <h2>{{ $contenido->titulo }}</h2>

    @if($contenido->descripcion)
        <div class="mb-3">
            {!! $contenido->descripcion !!}
        </div>
    @endif

    @if($contenido->imagen && Storage::disk('public')->exists($contenido->imagen))
        <div class="mb-3">
            <img src="{{ asset('storage/'.$contenido->imagen) }}" class="img-fluid rounded">
        </div>
    @endif

    {{-- Archivos adicionales --}}
    @if($contenido->archivos && $contenido->archivos->count())
        <div class="mb-4">
            <h5>Archivos adicionales</h5>
            <ul class="list-group">
                @foreach($contenido->archivos as $archivo)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @if($archivo->ruta && Storage::disk('public')->exists($archivo->ruta))
                            <a href="{{ asset('storage/'.$archivo->ruta) }}" target="_blank">{{ $archivo->nombre }}</a>
                        @else
                            <span class="text-muted">{{ $archivo->nombre }} (archivo no disponible)</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Cuadros con filtro --}}
    @if($contenido->cuadros && $contenido->cuadros->count())
        <div class="cuadros-box">
            <h5>Cuadros</h5>

            <select id="filter-dropdown" class="form-select form-select-sm mb-3">
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
                    @foreach($contenido->cuadros->sortBy('titulo') as $cuadro)
                        <tr class="cuadro-item" data-letter="{{ strtoupper(substr($cuadro->titulo ?? '', 0, 1)) }}">
                            <td>{{ $cuadro->titulo ?? '-' }}</td>
                            <td>{{ $cuadro->autor ?? '-' }}</td>
                            <td>
                                @if($cuadro->archivo && Storage::disk('public')->exists($cuadro->archivo))
                                    <a href="{{ asset('storage/'.$cuadro->archivo) }}" target="_blank">Ver archivo</a>
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
</main>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropdown = document.getElementById('filter-dropdown');
    if(!dropdown) return;

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
