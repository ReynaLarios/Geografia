@extends('public.layout')

@section('contenido')
<div class="container mt-4">

    
    @if($imagenesCarrusel->count() > 0)
        <div id="carouselPublico" class="carousel slide mb-4" data-bs-ride="carousel">
            <div class="carousel-inner text-center">
                @foreach($imagenesCarrusel as $index => $img)
                    <div class="carousel-item @if($index == 0) active @endif">
                        <img src="{{ asset('storage/'.$img->imagen) }}"
                             class="d-block mx-auto"
                             style="width:100%; max-height:400px; object-fit:cover;"
                             alt="Carrusel {{ $index + 1 }}">
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselPublico" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselPublico" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>
    @else
        <p class="text-center text-muted">No hay imágenes en el carrusel.</p>
    @endif

     @if($noticias->count())
    <ul class="list-group">
        @foreach ($noticias as $noticia)
            <li class="list-group-item d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
        @if($noticia->imagen)
            <img src="{{ asset('storage/'.$noticia->imagen) }}" alt="{{ $noticia->titulo }}" 
                 style="width:80px; height:80px; object-fit:cover; border-radius:5px; margin-right:10px;">
        @endif

        <div>
            <strong>{{ $noticia->titulo }}</strong><br>

            <small class="text-muted">
                Publicado el {{ $noticia->created_at->format('d/m/Y') }}
            </small>

            <div>
                <small>{{ \Illuminate\Support\Str::limit(strip_tags($noticia->descripcion), 80) }}</small>
                
            </div>
        </div>
           <div class="ms-2">
        <a href="{{ route('public.inicios.show', $noticia->slug) }}"
           class="btn btn-sm btn-secondary">
            Ver
        </a>
    </div>
    </div>
    

</li>


        @endforeach
        <div class="text-center mt-4">
    <a href="{{ route('public.inicio.historial') }}" class="btn btn-primary">
        Ver + noticias
    </a>
</div>

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


.carousel-inner img {
    width: 100%;
    height: auto;
    object-fit: cover;
}


@media (max-width: 576px) {
    .carousel-inner img {
        height: 250px; 
    }
    .carousel-caption {
        font-size: 0.8rem;
    }
    .list-group-item .d-flex img {
        width: 60px;
        height: 60px;
    }
}
</style>
@endsection
