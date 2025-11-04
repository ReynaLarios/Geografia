@extends('base.layout')

@section('contenido')
<main class="p-4">

    <h1 class="text-2xl font-bold mb-4">Secciones</h1>

    <div class="row">
        @foreach($secciones as $seccion)
            <div class="col-md-12 mb-4">
                <div class="card p-3">
                    <h3 class="card-title">{{ $seccion->nombre }}</h3>
                    <p class="card-text">{{ $seccion->descripcion }}</p>

                    @if($seccion->nombre == 'Multimedia')
                        <a href="{{ route('videoteca') }}" class="btn btn-success mt-2">Ver Videoteca</a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

</main>
@endsection
