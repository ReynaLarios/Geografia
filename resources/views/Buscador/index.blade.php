@extends('base.layout')

@section('contenido')

<div style="max-width:600px; margin:auto;">

    <h2 class="text-center mb-4" style="font-weight: bold;">🔎 Buscador</h2>

    <form action="{{ route('buscador.index') }}" method="GET"
          style="display:flex; gap:10px; justify-content:center;">

        <input type="text" name="search" placeholder="Buscar..."
               value="{{ $search ?? '' }}"
               style="
                   width: 300px;
                   padding: 10px 15px;
                   border-radius: 25px;
                   border: 1px solid #60a5fa;
                   outline:none;
               ">

        <button type="submit"
                style="
                    padding: 10px 20px;
                    border:none;
                    background:#3b82f6;
                    color:white;
                    border-radius:25px;
                    cursor:pointer;
                ">
            Buscar
        </button>
    </form>


    @if(isset($resultados) && count($resultados) > 0)
        <div class="mt-4">
            <h4>Resultados:</h4>

            <ul class="list-group">

                @foreach($resultados as $item)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $item->nombre }}

                        {{-- 🔗 Enlace correcto dinámico --}}
                        <a href="{{ $item->url }}"
                           style="color:#2563eb; text-decoration: underline;">
                            Ver
                        </a>
                    </li>
                @endforeach

            </ul>
        </div>

    @elseif(isset($search))
        <p class="mt-4 text-center">No se encontraron resultados.</p>
    @endif

</div>

@endsection
