@extends('base.layout') <!-- tu layout público -->

@section('contenido')
<div class="container mt-4">
    <h2>Personas</h2>
    <div class="row">
        @foreach($personas as $persona)
            <div class="col-md-4 mb-3">
                <div class="card">
                    @if($persona->foto)
                        <img src="{{ asset('storage/' . $persona->foto) }}" class="card-img-top" alt="{{ $persona->nombre }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $persona->nombre }}</h5>
                        <a href="{{ route('public.personas.show', $persona->id) }}" class="btn btn-primary btn-sm">Ver detalles</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
