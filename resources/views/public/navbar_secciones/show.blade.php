@extends('public.layout')

@section('contenido')
<div class="container mt-4">

    
    <h2 class="mb-4 text-center text-primary"><strong>{{ $seccion->nombre }}</strong></h2>

  
    @if(!empty($seccion->descripcion))
        <div class="mb-4 p-3 bg-light rounded shadow-sm">
            {!! $seccion->descripcion !!}
        </div>
    @endif


    @if(!empty($seccion->imagen))
        <div class="mb-4 text-center">
            <img src="{{ asset('storage/' . $seccion->imagen) }}" 
                 class="img-fluid rounded shadow-sm" 
                 style="max-height: 300px; object-fit: cover;">
        </div>
    @endif

   
    @if($seccion->archivos && count($seccion->archivos) > 0)
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

    {{-- Cuadros con filtro --}}
    @if($contenido->cuadros->isNotEmpty())
        <div class="cuadros-box">
            <h5>Cuadros</h5>

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
