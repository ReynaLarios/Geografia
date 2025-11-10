@extends('base.layout')

@section('contenido')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Carrusel</h2>
        <a href="{{ route('inicio.createImagen') }}" class="btn btn-success">➕ Nueva Imagen</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <ul class="list-group">
        @foreach($imagenes as $img)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <img src="{{ asset('storage/'.$img->imagen) }}" width="120" class="rounded me-3" alt="Imagen del carrusel">
                <div>
                    <a href="{{ route('inicio.editImagen', $img->id) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('inicio.destroyImagen', $img->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar imagen?')">Borrar</button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
</div>

<style>
.btn-success { background-color: #FFB77D; border-color: #FFB77D; color: #663300; }
.btn-warning { background-color: #FFF3B0; border-color: #FFF3B0; color: #664d03; }
.btn-danger { background-color: #DDB892; border-color: #DDB892; color: #5C4033; }
</style>
@endsection
