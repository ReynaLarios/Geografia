@extends('public.layout')

@section('contenido')
<div class="container mt-4">
    <h4 class="mb-4 fw-bold">Resultados para: <span class="text-primary">"{{ $q }}"</span></h4>

    @if($resultados->isEmpty())
        <div class="alert alert-warning text-center">No se encontraron resultados.</div>
    @else
        <div class="list-group">
            @foreach($resultados as $item)
                
                <a href="{{ $item->url }}" class="d-block mb-2 text-primary" style="font-size: 1.2rem; text-decoration: none;">
                    {{ $item->nombre }}
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection
