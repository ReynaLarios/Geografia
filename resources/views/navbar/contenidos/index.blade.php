@extends('base.layout')

@section('contenido')
<h2>Navbar Horizontal</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<button class="fancy mb-3" onclick="window.location='{{ route('navbar.crearSeccion') }}'">+ Agregar Sección</button>

<ul class="nav flex-column">
    @foreach($navbarSecciones as $seccion)
    <li class="mb-2 d-flex justify-content-between align-items-center">
        <span>{{ $seccion->nombre }}</span>
        <div class="d-flex gap-1">
            <a href="{{ route('navbar.editarSeccion', $seccion->id) }}" class="fancy">✎</a>
            <form action="{{ route('navbar.borrarSeccion', $seccion->id) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres borrar esta sección?')">
                @csrf
                @method('DELETE')
                <button class="fancy btn-borrar" type="submit">🗑</button>
            </form>
        </div>
    </li>
    @foreach($seccion->hijos as $hijo)
        <li class="ms-4 mb-2 d-flex justify-content-between align-items-center">
            <span>{{ $hijo->nombre }}</span>
            <div class="d-flex gap-1">
                <a href="{{ route('navbar.editarContenido', $hijo->id) }}" class="fancy">✎</a>
                <form action="{{ route('navbar.borrarContenido', $hijo->id) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres borrar este contenido?')">
                    @csrf
                    @method('DELETE')
                    <button class="fancy btn-borrar" type="submit">🗑</button>
                </form>
            </div>
        </li>
    @endforeach
    @endforeach
</ul>
@endsection
