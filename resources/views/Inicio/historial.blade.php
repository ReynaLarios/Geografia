@extends('base.layout')

@section('contenido')
<main class="container mt-4">

    <h2 class="mb-4 text-center">Historial de Noticias</h2>

    @foreach($noticias as $noticia)
    <div class="card mb-3 p-2">

        <div class="d-flex align-items-start">

            {{-- IMAGEN PEQUEÑA A LA IZQUIERDA --}}
            @if($noticia->imagen)
                <img 
                    src="{{ asset('storage/'.$noticia->imagen) }}" 
                    alt="{{ $noticia->titulo }}"
                    style="width: 90px; height: 90px; object-fit: cover; border-radius: 8px; margin-right: 15px;"
                >
            @endif

            <div class="flex-grow-1">
                <h4 class="mb-1">{{ $noticia->titulo }}</h4>

                {{-- FECHA --}}
                <small class="text-muted">
                    Publicado el {{ $noticia->created_at->format('d/m/Y') }}
                </small>

                <p class="mt-2">{!! Str::limit($noticia->descripcion, 250) !!}</p>

                <a href="{{ route('inicio.show', $noticia->slug) }}" class="btn btn-sm btn-outline-primary">
                    Leer más
                </a>
            </div>

        </div>

    </div>
    @endforeach

    <div class="mt-4">
        {{ $noticias->links() }}
    </div>

</main>
@endsection
