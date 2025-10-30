@extends('base.layout')

@section('contenido')
    <div class="container mt-4">

        {{-- Carrusel de Noticias --}}
        <div id="carouselNoticias" class="carousel slide mb-4" data-bs-ride="carousel">
            <div class="carousel-inner text-center">
                @foreach ($inicio as $index => $in)
                    <div class="carousel-item @if ($index == 0) active @endif">
                        @if ($in->imagen)
                            <img src="{{ asset('storage/' . $in->imagen) }}" class="d-block mx-auto carousel-img"
                                alt="{{ $in->titulo }}">
                        @else
                            <img src="{{ asset('GE.png') }}" class="d-block mx-auto carousel-img" alt="Imagen por defecto">
                        @endif
                        {{-- Botón para editar/subir la imagen --}}
                        <div class="carousel-caption d-none d-md-block">
                            <a href="{{ route('dashboard', $in->id) }}" class="btn btn-sm btn-primary">Editar / Subir
                                Imagen</a>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Controles del carrusel --}}
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselNoticias" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselNoticias" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>

        {{-- Noticias --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Noticias</h2> <a href="{{ route('dashboard') }}" class="btn btn-success">➕ Nueva Noticia</a>
        </div>
        @if (session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
            @endif <ul class="list-group">
                @foreach ($inicio as $in)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            @if ($in->imagen)
                                <img src="{{ asset('storage/' . $in->imagen) }}" width="70" height="70"
                                    class="rounded me-3" alt="imagen">
                            @endif
                            <div> <strong>{{ $in->titulo }}</strong><br>
                                <small>{{ \Illuminate\Support\Str::limit($in->descripcion, 80) }}</small> </div>
                        </div>
                        <div> <a href="{{ route('dashboard', $in->id) }}" class="btn btn-sm btn-info">Ver</a> <a
                                href="{{ route('dashboard', $in->id) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('dashboard', $in->id) }}" method="POST" style="display:inline;"> @csrf
                                @method('DELETE') <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('¿Eliminar noticia?')">Borrar</button> </form>
                        </div>
                    </li>
                @endforeach
            </ul>
</div>
</ul>

</div>

{{-- Estilos para carrusel y botones --}}
<style>
    .carousel-img {
        max-height: 400px;
        object-fit: cover;
        width: 100%;
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
