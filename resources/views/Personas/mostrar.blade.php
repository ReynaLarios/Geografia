@extends('base.layout')

@section('contenido')
<div class="container mt-4">
    <h2>Detalles de Persona</h2>
    <div class="card p-3">
        @if($persona->foto)
            <img src="{{ asset('storage/' . $persona->foto) }}" width="150" class="mb-3">
        @endif
        <p><strong>Nombre:</strong> {{ $persona->nombre }}</p>
        <p><strong>Email:</strong> {{ $persona->email }}</p>
        <p><strong>Datos Adicionales:</strong> {{ $persona->datos_adicionales }}</p>
        <a href="{{ route('personas.index') }}" class="btn btn-secondary">Volver</a>
    </div>
</div>
@endsection
