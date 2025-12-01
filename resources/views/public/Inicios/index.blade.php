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

    <h2 class="mb-4 text-center">Historial de Noticias</h2>

    @if($noticias->count() > 0)
        @foreach($noticias as $noticia)
            <div class="card mb-3 p-2">
                <div class="d-flex align-items-start">

                    
                    @if($noticia->imagen)
                        <img 
                            src="{{ asset('storage/'.$noticia->imagen) }}" 
                            alt="{{ $noticia->titulo }}"
                            style="width: 90px; height: 90px; object-fit: cover; border-radius: 8px; margin-right: 15px;"
                        >
                    @endif

                    <div class="flex-grow-1">
                        <h4 class="mb-1">{{ $noticia->titulo }}</h4>

                      
                        <small class="text-muted">
                            Publicado el {{ $noticia->created_at->format('d/m/Y') }}
                        </small>

                        <p class="mt-2 mb-2">{!! Str::limit($noticia->descripcion, 200) !!}</p>

                        <a href="{{ route('inicio.show', $noticia->slug) }}" class="btn btn-sm btn-outline-primary">
                            Leer más
                        </a>
                    </div>

                </div>
            </div>
        @endforeach
    @else
        <p class="text-center text-muted">No hay noticias aún.</p>
    @endif

</div>
@endsection
