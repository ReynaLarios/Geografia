@extends('base.layout')

@section('contenido')
<div class="container mt-4">

    {{-- ================== CARRUSEL ================== --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Carrusel</h2>
        <a href="{{ route('inicio.createImagen') }}" class="btn btn-success">➕ Agregar Imagen</a>
    </div>

    @if($imagenes->count())
    <div id="carouselInicio" class="carousel slide mb-4" data-bs-ride="carousel">
        <div class="carousel-inner text-center">
            @foreach($imagenes as $index => $img)
                <div class="carousel-item @if($index==0) active @endif">
                    <img src="{{ asset('storage/'.$img->imagen) }}" class="d-block mx-auto" style="max-height:400px; width:100%;" alt="Carrusel {{ $index+1 }}">
                    <div class="carousel-caption d-none d-md-block">
                        <a href="{{ route('inicio.editImagen', $img->id) }}" class="btn btn-sm btn-primary">Editar</a>
                        <form action="{{ route('inicio.destroyImagen', $img->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar imagen?')">Borrar</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselInicio" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselInicio" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </div>
    @else
        <p class="text-center">No hay imágenes en el carrusel aún.</p>
    @endif

    {{-- ================== NOTICIAS ================== --}}
    <div class="d-flex justify-content-between align-items-center mb-3 mt-5">
        <h2>Noticias</h2>
        <a href="{{ route('inicio.create') }}" class="btn btn-success">➕ Nueva Noticia</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    @if($noticias->count())
    <ul class="list-group">
        @foreach ($noticias as $noticia)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <strong>{{ $noticia->titulo }}</strong><br>
                    <small>{{ \Illuminate\Support\Str::limit($noticia->descripcion, 80) }}</small>
                </div>
                <div>
                    <a href="{{ route('inicio.show', $noticia->id) }}" class="btn btn-sm btn-info">Ver</a>
                    <a href="{{ route('inicio.edit', $noticia->id) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('inicio.destroy', $noticia->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar noticia?')">Borrar</button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
    @else
        <p class="text-center">No hay noticias aún.</p>
    @endif
</div>

<style>
.carousel-caption .btn {
    margin: 2px;
}

.btn-success {
    background-color: #FFB77D;
    border-color: #FFB77D;
    color: #663300;
}

.btn-info {
    background-color: #A0C4FF;
    border-color: #A0C4FF;
    color: #03045e;
}

.btn-warning {
    background-color: #FFF3B0;
    border-color: #FFF3B0;
    color: #664d03;
}

.btn-danger {
    background-color: #DDB892;
    border-color: #DDB892;
    color: #5C4033;
}

.carousel-caption .btn-primary {
    background-color: #79A7D3;
    border-color: #79A7D3;
    color: #fff;
}
</style>
@endsection
