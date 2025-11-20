@extends('base.layout')

@section('contenido')
<div class="container mt-4">
    <div class="card p-3">
        @if($persona->foto)
            <img src="{{ asset('storage/' . $persona->foto) }}" width="200" class="mb-3">
        @endif
        <h3>{{ $persona->nombre }}</h3>
        <p><strong>Email:</strong> {{ $persona->email }}</p>
        <p><strong>Datos adicionales:</strong> {{ $persona->datos_adicionales }}</p>
        <a href="{{ route('public.personas.index') }}" class="btn btn-secondary">Volver</a>
    </div>
</div>
@endsection
