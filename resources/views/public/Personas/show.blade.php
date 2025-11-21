@extends('base.layout')

@section('contenido')
<div class="container mt-5">
    <a href="{{ route('public.personas.index') }}" class="btn btn-secondary mb-4">← Volver al listado</a>

    <div class="card mx-auto" style="max-width: 400px; background-color: #dbeafe; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
        <div class="card-body text-center p-4">

            {{-- Foto redonda --}}
            @if($persona->foto)
                <img src="{{ asset('storage/' . $persona->foto) }}" 
                     alt="Foto de {{ $persona->nombre }}" 
                     class="rounded-circle mb-3"
                     style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #90caf9;">
            @else
                <div class="rounded-circle mb-3 d-flex align-items-center justify-content-center" 
                     style="width: 120px; height: 120px; background-color: #bbdefb; color: #1565c0; font-size: 36px;">
                    {{ strtoupper(substr($persona->nombre, 0, 1)) }}
                </div>
            @endif

            {{-- Nombre --}}
            <h4 class="card-title fw-bold">{{ $persona->nombre }}</h4>

            {{-- Email --}}
            <p class="text-muted mb-2">{{ $persona->email }}</p>

            {{-- Datos personales --}}
            @if($persona->datos_personales)
                <div class="card-text text-start mt-3 p-3" style="background-color: #bbdefb; border-radius: 10px; font-size: 14px;">
                    {!! $persona->datos_personales !!}
                </div>
            @endif

        </div>
    </div>
</div>
@endsection


