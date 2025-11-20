@extends('base.layout')

@section('contenido')
<div class="container mt-4">

    <h2 class="mb-3"><strong>Cuadros</strong></h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Formulario para agregar cuadro --}}
    <form action="{{ route('cuadros.guardar') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <input type="text" name="titulo" class="form-control" placeholder="Título" required>
            </div>

            <div class="col-md-4">
                <input type="text" name="autor" class="form-control" placeholder="Autor">
            </div>

            <div class="col-md-3">
                <input type="file" name="archivo" class="form-control" accept=".pdf,.doc,.docx,.pptx,.xlsx">
            </div>

            <div class="col-md-1 d-flex align-items-center">
                <button type="submit" class="btn btn-primary w-100">Agregar</button>
            </div>
        </div>
    </form>

    @if($cuadros->count() > 0)
        {{-- Filtro alfabético --}}
        <div class="mb-3">
            <strong>Filtrar por letra:</strong>
            @foreach(range('A', 'Z') as $letter)
                <button class="btn btn-outline-primary btn-sm filter-letter mb-1" data-letter="{{ $letter }}">{{ $letter }}</button>
            @endforeach
            <button class="btn btn-outline-secondary btn-sm mb-1" id="filter-all">Todos</button>
        </div>

        {{-- Contenedor de cuadros --}}
        <div class="row" id="cuadros-container">
            @foreach($cuadros->sortBy('titulo') as $cuadro)
                <div class="col-md-4 mb-4 cuadro-item" data-letter="{{ strtoupper(substr($cuadro->titulo, 0, 1)) }}">
                    <div class="card shadow-sm h-100 cuadro-card">
                        <div class="card-body d-flex flex-column">

                            <h5 class="card-title">{{ $cuadro->titulo }}</h5>

                            <p class="card-text mb-2">
                                <strong>Autor:</strong> {{ $cuadro->autor ?? '-' }}
                            </p>

                            @if($cuadro->archivo)
                                <a href="{{ asset('storage/'.$cuadro->archivo) }}"
                                   download="{{ $cuadro->nombre_real }}"
                                   class="btn btn-outline-primary w-100 mb-2">
                                    Descargar: {{ $cuadro->nombre_real }}
                                </a>
                                <small class="text-muted">
                                    Tamaño: {{ number_format(Storage::disk('public')->size($cuadro->archivo)/1024/1024, 2) }} MB
                                </small>
                            @else
                                <p class="text-muted">No hay archivo adjunto</p>
                            @endif

                            <div class="mt-auto d-flex gap-1">
                                <a href="{{ route('cuadros.editar', $cuadro->id) }}" class="btn btn-warning w-50">Editar</a>

                                <form action="{{ route('cuadros.borrar', $cuadro->id) }}" method="POST" class="w-50">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger w-100" type="submit" onclick="return confirm('¿Eliminar este cuadro?')">
                                        Eliminar
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>No hay cuadros agregados.</p>
    @endif

</div>
@endsection

@section('styles')
<style>
/* Estilo para las tarjetas de cuadros */
.cuadro-card {
    transition: transform 0.2s, box-shadow 0.2s;
    border: 1px solid #007BFF33; /* azul suave */
}
.cuadro-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,123,255,0.3);
    border-color: #007BFF;
}

/* Botón activo del filtro */
button.filter-letter.active, #filter-all.active {
    background-color: #007BFF !important;
    color: #fff !important;
    border-color: #007BFF !important;
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const botones = document.querySelectorAll('.filter-letter');
    const btnTodos = document.getElementById('filter-all');
    const cuadros = document.querySelectorAll('.cuadro-item');

    botones.forEach(btn => {
        btn.addEventListener('click', () => {
            const letra = btn.dataset.letter;

            // Mostrar/ocultar cuadros
            cuadros.forEach(c => {
                c.style.display = c.dataset.letter === letra ? 'block' : 'none';
            });

            // Resaltar botón activo
            botones.forEach(b => b.classList.remove('active'));
            btnTodos.classList.remove('active');
            btn.classList.add('active');
        });
    });

    btnTodos.addEventListener('click', () => {
        cuadros.forEach(c => c.style.display = 'block');

        botones.forEach(b => b.classList.remove('active'));
        btnTodos.classList.add('active');
    });
});
</script>
@endsection
