@extends('public.layout_public')

@section('contenido')
<div class="container">
    <h2 class="fw-bold text-primary mb-4">{{ $contenido->nombre }}</h2>

    @if($contenido->texto)
        <div class="contenido-texto mb-4">
            {!! $contenido->texto !!}
        </div>
    @endif

    @if($contenido->archivo)
        <div class="archivo mt-4">
            <a href="{{ asset('storage/'.$contenido->archivo) }}" target="_blank" class="btn btn-primary">
                📄 Ver archivo adjunto
            </a>
        </div>
    @endif
</div>
@endsection
