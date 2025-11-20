@extends('public.layout')


@section('contenido')
<div class="container mt-4">

    {{-- CARRUSEL (SIN BOTONES ADMIN) --}}
    @if($imagenes->count())
    <div id="carouselInicio" class="carousel slide mb-4" data-bs-ride="carousel">
        <div class="carousel-inner text-center">
            @foreach($imagenes as $index => $img)
                <div class="carousel-item @if($index==0) active @endif">
                    <img src="{{ asset('storage/'.$img->imagen) }}" class="d-block mx-auto"
                         style="max-height:400px; width:100%;" alt="Carrusel {{ $index+1 }}">
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


    {{-- NOTICIAS (SOLO VER, SIN EDITAR/ELIMINAR) --}}
    <div class="d-flex justify-content-between align-items-center mb-3 mt-5">
        <h2>Noticias</h2>
    </div>

    @if($noticias->count())
    <ul class="list-group">
        @foreach ($noticias as $noticia)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <strong>{{ $noticia->titulo }}</strong><br>
                    <small>{{ \Illuminate\Support\Str::limit($noticia->descripcion, 80) }}</small>
                </div>
            </li>
        @endforeach
    </ul>
    @else
        <p class="text-center">No hay noticias aún.</p>
    @endif
</div>

<style>
.btn-info {
    background-color: #A0C4FF;
    border-color: #A0C4FF;
    color: #03045e;
}
</style>
@endsection
