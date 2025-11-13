@extends('base.layout')

@section('contenido')
<div class="container mt-4">
    <h2 class="mb-4 text-center">Panel de Secciones del Navbar</h2>

    @if(session('ok'))
        <div class="alert alert-success">{{ session('ok') }}</div>
    @endif

    <div class="row g-3">
        @foreach($navbarSecciones as $seccion)
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    @if($seccion->imagen)
                        <img src="{{ asset('storage/'.$seccion->imagen) }}" class="card-img-top" style="height: 150px; object-fit: cover;">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title mb-2">{{ $seccion->nombre }}</h5>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('navbar.secciones.mostrar', $seccion->id) }}" class="btn btn-outline-secondary btn-sm">👁 Ver</a>
                            <a href="{{ route('navbar.secciones.editar', $seccion->id) }}" class="btn btn-outline-primary btn-sm">✎</a>
                            <form action="{{ route('navbar.secciones.borrar', $seccion->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Eliminar esta sección?')">🗑</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
