@extends('publico.layout')

@section('contenido')

<div style="max-width:650px; margin:auto; padding:20px;">

    <h2 class="mb-4">Resultados de búsqueda</h2>

    @if(isset($resultados) && $resultados->count())
        <ul class="list-group">
            @foreach ($resultados as $item)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $item->nombre }}

                    <a href="{{ $item->url }}" 
                       style="color:#2563eb; text-decoration:underline;">
                        Ver
                    </a>
                </li>
            @endforeach
        </ul>

    @elseif($search)
        <p class="mt-4 text-center">No hay coincidencias.</p>
    @endif

</div>

@endsection
