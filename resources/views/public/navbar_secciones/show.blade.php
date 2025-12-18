@extends('public.layout')

@section('contenido')
<div class="container mt-4">

    
    <h2 class="mb-4 text-center text-primary"><strong>{{ $seccion->nombre }}</strong></h2>
@if($seccion->imagen)
    <div class="imagen-cuadrada mx-auto mb-4">
        <img src="{{ asset('storage/'.$seccion->imagen) }}" 
             alt="{{ $seccion->titulo ?? 'Imagen' }}">
    </div>
@endif

    @if(!empty($seccion->descripcion))
        <div class="mb-4 p-3 bg-light rounded shadow-sm">
            {!! $seccion->descripcion !!}
        </div>
    @endif

   
   @if($seccion->archivos && $seccion->archivos->count())
    <div class="mb-4">
        <ul class="list-group">
            @foreach($seccion->archivos as $archivo)
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
                    <script>
document.getElementById('filter-dropdown').addEventListener('change', function() {
    const selected = this.value;
    const rows = document.querySelectorAll('.cuadro-item');

    rows.forEach(row => {
        const letter = row.getAttribute('data-letter');

        if (selected === 'all' || letter === selected) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
<div class="mt-3">
    <button class="fancy" onclick="window.history.back()">← Regresar</button>
</div>

@endsection
