@extends('base.layout')

@section('contenido')
<div class="container mt-5">
    <h4 class="mb-4 fw-bold">Resultados para: <span class="text-primary">"{{ $q }}"</span></h4>

    @if($resultados->isEmpty())
        <div class="alert alert-warning text-center">No se encontraron resultados.</div>
    @else
        <ul class="list-group list-group-flush">
            @foreach($resultados as $resultado)
                <li class="list-group-item">
                    <a href="{{ $resultado->url }}" class="text-decoration-none text-primary">
                        {{ $resultado->nombre }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
