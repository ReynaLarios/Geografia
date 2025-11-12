@extends('public.layout_public')

@section('contenido')
<div class="container">
    <h2 class="fw-bold text-primary mb-4">Videoteca</h2>

    @if($videos && $videos->count())
        <div class="row g-4">
            @foreach($videos as $video)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="ratio ratio-16x9">
                        {!! $video->iframe !!}
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $video->titulo }}</h5>
                        <p class="card-text text-muted">{{ $video->descripcion }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <p class="text-muted fst-italic">Aún no hay videos disponibles en la videoteca.</p>
    @endif
</div>
@endsection
