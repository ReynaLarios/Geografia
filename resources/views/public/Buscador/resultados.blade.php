@extends('layout')

@section('contenido')
<h2>Resultados de búsqueda para "{{ $q }}"</h2>

@if($resultados->isEmpty())
    <p>No se encontraron resultados.</p>
@else
    <ul class="list-group">
        @foreach($resultados as $item)
            <li class="list-group-item">
                <a href="{{ $item->url() }}">
                    <strong>{{ $item->nombre }}</strong> ({{ $item->tipo }})
                </a>
                <p>{{ $item->descripcion }}</p>
            </li>
        @endforeach
    </ul>
@endif
@endsection
