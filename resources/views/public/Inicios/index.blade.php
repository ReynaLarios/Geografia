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

  
    <h2 class="mb-3 mt-5">Noticias</h2>

    @if($noticias->count() > 0)
        <ul class="list-group">
            @foreach($noticias as $noticia)
                <li class="list-group-item mb-3 p-3 shadow-sm rounded">
                    <div class="d-flex align-items-start">
                        
                        @if($noticia->imagen)
                            <img src="{{ asset('storage/'.$noticia->imagen) }}" 
                                 alt="{{ $noticia->titulo }}" 
                                 class="rounded me-3" 
                                 style="width:120px; height:120px; object-fit:cover;">
                        @endif

                        <div class="flex-grow-1">
                            <h4>{{ $noticia->titulo }}</h4>
                            <p>{{ strip_tags($noticia->descripcion) }}</p>

                           
                            @if($noticia->archivos->count() > 0)
                                <h6>Archivos adjuntos:</h6>
                                <ul>
                                    @foreach($noticia->archivos as $archivo)
                                        <li>
                                            <a href="{{ asset('storage/archivos/'.$archivo->archivo) }}" target="_blank">
                                                {{ $archivo->nombre_real }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-center text-muted">No hay noticias aún.</p>
    @endif

</div>


<style>
.btn-info {
    background-color: #A0C4FF;
    border-color: #A0C4FF;
    color: #03045e;
}
.list-group-item {
    background-color: #dbeafe;
    border-color:#dbeafe;
}
</style>
@endsection
