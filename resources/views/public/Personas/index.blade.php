@extends('public.layout')

@section('contenido')
<div class="container mt-5">
    <h2 class="mb-4 text-center" style="color: #1565c0;">ACADEMICOS</h2>

     <div class="d-flex flex-wrap justify-content-center gap-4">
        @foreach($personas as $persona)
            <a href="{{ route('public.personas.show', $persona->slug) }}" 
               class="card shadow-sm text-center text-decoration-none"
               style="width: 180px; border-radius: 12px; background-color: #dbeafe; color: inherit; transition: transform 0.2s;">

                <div class="p-3">
                    @if($persona->foto)
                        <img src="{{ asset('storage/' . $persona->foto) }}" 
                             class="rounded-circle mb-2"
                             style="width: 100px; height: 100px; object-fit: cover; border: 2px solid #90caf9;">
                    @else
                        <div class="rounded-circle d-flex align-items-center justify-content-center mb-2"
                             style="width: 100px; height: 100px; object-fit: cover; border: 2px solid #90caf9;margin:auto">
                             {{ strtoupper(substr($persona->nombre, 0, 1)) }}
                        </div>
                    @endif
  </div>
                   <div class="fw-bold persona-nombre">
                       {{ $persona->nombre }}
                    </div>
            </a>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $personas->links('pagination::bootstrap-5') }}
    </div>
</div>

 <div class="mt-3">
        <button class="fancy" onclick="window.history.back()">← Regresar</button>
    </div>
<style>
.persona-card {
    width: 180px;
    min-height: 210px; 
    border-radius: 15px;
    background-color: #dbeafe;
    color: inherit;
    transition: transform 0.2s;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
}
.persona-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 12px rgba(0,0,0,0.15);
    border-color: #42a5f5;
}
.persona-foto {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 50%;
    border: 3px solid #90caf9;
}
.persona-foto.placeholder {
    background-color: #90caf9;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1.5rem;
}
.persona-nombre {
    font-size: 1rem;
    margin: 0 10px 10px 10px;
    word-wrap: break-word;
}
</style>
@endsection

