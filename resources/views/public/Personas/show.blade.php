@extends('public.layout')

@section('contenido')

<style>
/* ===== FOTO PERFIL PUBLIC ===== */
.foto-public-wrap {
    position: relative;
    width: 200px;
    height: 200px;
    margin: auto;
}

.foto-public-bg {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, #93c5fd, #bfdbfe);
    clip-path: polygon(10% 0%, 100% 0%, 90% 100%, 0% 100%);
    border-radius: 16px;
    transform: translate(8px, 8px);
}

.foto-public {
    position: relative;
    width: 200px;
    height: 200px;
    background: #fff;
    clip-path: polygon(10% 0%, 100% 0%, 90% 100%, 0% 100%);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 12px 26px rgba(0,0,0,0.2);
}

.foto-public img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.foto-public-fallback {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #2563eb, #60a5fa);
    color: #fff;
    font-size: 64px;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* ===== TARJETA PUBLIC ===== */
.card-public {
    max-width: 900px;
    margin: auto;
    background: #f8fbff;
    border-radius: 20px;
    box-shadow: 0 14px 30px rgba(0,0,0,0.1);
}
</style>

<div class="container mt-5">

    <a href="{{ route('public.personas.index') }}"
       class="btn btn-secondary mb-4">
        ← Volver al listado
    </a>

    <div class="card card-public">
        <div class="card-body text-center p-5">

<<<<<<< HEAD
            {{-- FOTO --}}
            <div class="foto-public-wrap mb-4">
                <div class="foto-public-bg"></div>

                <div class="foto-public">
                    @if($persona->foto)
                        <img src="{{ asset('storage/' . $persona->foto) }}"
                             alt="Foto de {{ $persona->nombre }}">
                    @else
                        <div class="foto-public-fallback">
                            {{ strtoupper(substr($persona->nombre, 0, 1)) }}
                        </div>
                    @endif
=======
            @if($persona->foto)
                <img src="{{ asset('storage/' . $persona->foto) }}" 
                     alt="Foto de {{ $persona->nombre }}" 
                     class="rounded-circle mb-3"
                     style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #90caf9;margin:auto">
            @else
                <div class="rounded-circle mb-3 d-flex align-items-center justify-content-center" 
                     style="width: 150px; height: 150px; background-color: #bbdefb; color: #1565c0; font-size: 48px;">
                    {{ strtoupper(substr($persona->nombre, 0, 1)) }}
>>>>>>> eba1e1b56ca3de689a61e55a63036367aaf40903
                </div>
            </div>

            {{-- NOMBRE --}}
            <h2 class="fw-bold mb-1">{{ $persona->nombre }}</h2>

            {{-- EMAIL --}}
            <p class="text-muted mb-4">{{ $persona->email }}</p>

            {{-- DATOS --}}
            @if($persona->datos_personales)
                <div class="text-start p-4"
                     style="background:#e0efff; border-radius:16px;">
                    {!! $persona->datos_personales !!}
                </div>
            @endif

            {{-- REGRESAR --}}
            <div class="mt-4">
                <button class="fancy"
                        onclick="window.history.back()">
                    ← Regresar
                </button>
            </div>

        </div>
    </div>

</div>

@endsection
