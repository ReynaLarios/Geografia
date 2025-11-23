@extends('base.layout')

@section('contenido')
<div class="container mt-5">
    <h2 class="mb-4 text-center" style="color: #1565c0;">ACADEMICOS</h2>

    <div class="d-flex flex-wrap justify-content-center gap-3">
        @foreach($personas as $persona)
            <a href="{{ route('public.personas.show', $persona->id) }}" 
               class="card shadow-sm text-center text-decoration-none"
               style="width: 180px; border-radius: 12px; background-color: #dbeafe; color: inherit; transition: transform 0.2s;">

                <div class="p-3">
                    @if($persona->foto)
                        <img src="{{ asset('storage/' . $persona->foto) }}" 
                             class="rounded-circle mb-2"
                             style="width: 100px; height: 100px; object-fit: cover; border: 2px solid #90caf9;">
                    @else
                        <div class="rounded-circle d-flex align-items-center justify-content-center mb-2"
                             style="width: 100px; height: 100px; background-color: #90caf9; color: white; font-weight: bold; font-size: 1.2rem;">
                             {{ strtoupper(substr($persona->nombre, 0, 1)) }}
                        </div>
                    @endif

                    <div class="fw-bold" style="font-size: 1rem;">
                       {{ $persona->nombre }}
                    </div>
                </div>

            </a>
        @endforeach
    </div>

    <!-- Paginación -->
    <div class="d-flex justify-content-center mt-4">
        {{ $personas->links('pagination::bootstrap-5') }}
    </div>
</div>

<style>
.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 12px rgba(0,0,0,0.15);
    border-color: #42a5f5;
}
</style>
@endsection

