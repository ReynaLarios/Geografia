@extends('base.layout')

@section('contenido')
<div class="container mt-4">
    <h2>{{ $contenido->nombre }}</h2>

    @if($contenido->ruta)
        <p><strong>Ruta:</strong> {{ $contenido->ruta }}</p>
    @endif

    <p>Aquí puedes poner el contenido de esta sección del navbar.</p>
</div>
@endsection
