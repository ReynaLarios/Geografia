@extends('base.layout')

@section('contenido')
<div class="container mt-5">

    <a href="{{ route('personas.index') }}" class="btn btn-secondary mb-4">← Volver al listado</a>

    <div class="card mx-auto" style="max-width: 900px; background-color: #dbeafe; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
        <div class="card-body text-center p-4">

            @if($persona->foto)
                <img src="{{ asset('storage/' . $persona->foto) }}" 
                     alt="Foto de {{ $persona->nombre }}" 
                     class="rounded-circle mb-3"
                     style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #90caf9;">
            @else
                <div class="rounded-circle d-flex align-items-center justify-content-center mb-2"
                     style="width: 100px; height: 100px; object-fit: cover; border: 2px solid #90caf9; margin:auto; font-size:40px;">
                    {{ strtoupper(substr($persona->nombre, 0, 1)) }}
                </div>
            @endif

            <h3 class="card-title fw-bold">{{ $persona->nombre }}</h3>

            <p class="text-muted mb-2">{{ $persona->email }}</p>
           
            @if($persona->datos_personales)
                <div class="card-text text-start mt-3 p-3" style="background-color: #bbdefb; border-radius: 10px;">
                    {!! $persona->datos_personales !!}
                </div>
            @endif

            <div class="mt-4 d-flex justify-content-center gap-3">

                <a href="{{ route('personas.editar', $persona->slug) }}" 
                   class="btn btn-primary">
                    Editar
                </a>

                <form action="{{ route('personas.borrar', $persona->slug) }}" 
                      method="POST"
                      onsubmit="return confirm('¿Seguro que deseas eliminar esta persona?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        Eliminar
                    </button>
                </form>

            </div>

        </div>
    </div>
</div>
@endsection
