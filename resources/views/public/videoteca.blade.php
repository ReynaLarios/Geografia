@extends('public.layout')

@section('title', 'Videoteca')

@section('contenido')
<h2 class="mb-4">Videoteca</h2>

@if($videos->isEmpty())
    <p>No hay videos disponibles.</p>
@else
    <div class="row">
        @foreach($videos as $video)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    {{-- Reproductor funcional --}}
                    <video class="w-100" controls preload="metadata">
                        <source src="{{ asset('storage/videos/' . $video->url) }}" type="video/mp4">
                        Tu navegador no soporta video.
                    </video>

                    <div class="card-body">
                        <h5 class="card-title">{{ $video->titulo }}</h5>
                        @if(!empty($video->descripcion))
                            <p class="card-text">{{ $video->descripcion }}</p>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
