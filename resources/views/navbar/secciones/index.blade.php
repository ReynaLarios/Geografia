@extends('base.layout')

@section('contenido')
<style>

.navbar-secciones-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.seccion-card {
    background: #fff;
    border-radius: 14px;
    padding: 20px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.08);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: transform 0.2s, box-shadow 0.2s;
}

.seccion-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.12);
}

.seccion-card h5 {
    color: #0d3b66;
    font-weight: 700;
    margin-bottom: 10px;
    font-size: 1.2rem;
}

.seccion-card p {
    color: #333;
    font-size: 0.95rem;
    flex-grow: 1;
    margin-bottom: 15px;
}


.btn-modern {
    background: #fff;
    color: inherit;
    border: 2px solid currentColor;
    font-size: 0.85rem;
    padding: 6px 12px;
    border-radius: 6px;
    font-weight: 600;
    transition: background 0.2s, transform 0.2s, color 0.2s;
}

.btn-modern:hover {
    background: currentColor;
    color: #fff;
    transform: translateY(-2px);
}

.card-actions {
    display: flex;
    gap: 5px;
    flex-wrap: wrap;
}
</style>

<div class="container mt-4">
    <h2 class="text-center mb-4">Listado de Navbar Secciones</h2>

    @if(session('ok'))
        <div class="alert alert-success text-center">{{ session('ok') }}</div>
    @endif

    <div class="navbar-secciones-grid">
        @foreach($navbarSecciones as $seccion)
            <div class="seccion-card">
                <h5>{{ $seccion->nombre }}</h5>
                <p>{{ Str::limit(strip_tags($seccion->descripcion), 120) }}</p>
                <div class="card-actions">
                    <a href="{{ route('navbar.secciones.mostrar', $seccion->id) }}" class="btn-modern" style="color:#0d6efd;">Ver</a>
                    <a href="{{ route('navbar.secciones.editar', $seccion->id) }}" class="btn-modern" style="color:#ffc107;">Editar</a>
                    <form action="{{ route('navbar.secciones.borrar', $seccion->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-modern" style="color:#dc3545;" onclick="return confirm('¿Seguro que deseas eliminar esta sección?')">Borrar</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
