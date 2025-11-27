@extends('public.layout')

@section('contenido')
<div class="container mt-4 text-center">

   
    @if(!empty($persona->foto) && file_exists(public_path('storage/' . $persona->foto)))
        <img src="{{ asset('storage/' . $persona->foto) }}" 
             class="rounded-circle mb-3" 
             style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #90caf9;">
    @else
        <div class="rounded-circle mb-3 d-flex align-items-center justify-content-center" 
             style="width:120px; height:120px; background:#bbdefb; color:#1565c0; font-size:36px;">
            {{ strtoupper(substr($persona->nombre ?? '', 0, 1)) }}
        </div>
    @endif

    <h3 class="fw-bold">{{ $persona->nombre ?? 'Nombre no disponible' }}</h3>
    <p class="text-muted">{{ $persona->email ?? 'Correo no disponible' }}</p>

    
    @if(!empty($persona->datos_personales))
        <div class="p-3 bg-light rounded shadow-sm mt-3 text-start">
            {!! $persona->datos_personales !!}
        </div>
    @endif

    <div class="mt-3">
        <button class="fancy" onclick="window.history.back()">← Regresar</button>
    </div>

</div>
@endsection
