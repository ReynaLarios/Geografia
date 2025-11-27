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

<div class="container mt-4">

    <h2 class="mb-4 text-center">{{ $contenido->titulo }}</h2>
    @if($contenido->descripcion)
        <p>{!! $contenido->descripcion !!}</p>
    @endif

    @if($contenido->imagen)
        <div class="mb-3 text-center">
            <img src="{{ asset('storage/'.$contenido->imagen) }}" class="img-fluid rounded" style="max-height: 300px; object-fit: cover;">
        </div>
    @endif
    
    @if($contenido->archivos && count($contenido->archivos))
        <div class="mb-4">
            <h5>Archivos adicionales</h5>
            <ul class="list-group">
                @foreach($contenido->archivos as $archivo)
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
    
    @if($contenido->cuadros->isNotEmpty())
        <div class="cuadros-box">
            <h5>Cuadros</h5>

            
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
                    @foreach($contenido->cuadros->sortBy('titulo') as $cuadro)
                        <tr class="cuadro-item" data-letter="{{ strtoupper(substr($cuadro->titulo,0,1)) }}">
                            <td>{{ $cuadro->titulo }}</td>
                            <td>{{ $cuadro->autor ?? '-' }}</td>
                            <td>
                                @if($cuadro->archivo)
                                    @php
                                        $tamano = Storage::disk('public')->size($cuadro->archivo);
                                        $tamanoMB = number_format($tamano / 1024 / 1024, 2);
                                    @endphp
                                    <a href="{{ asset('storage/'.$cuadro->archivo) }}" target="_blank">{{ basename($cuadro->archivo) }}</a>
                                    <small class="text-muted d-block">({{ $tamanoMB }} MB)</small>
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

</div>
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
