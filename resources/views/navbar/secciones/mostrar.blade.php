@extends('base.layout')

@section('contenido')
<div class="container mt-4">
    <h2>{{ $seccion->nombre }}</h2>

    <p>{!! $seccion->descripcion !!}</p>

    @if($seccion->imagen)
        <h5>Imagen principal:</h5>
        <img src="{{ asset('storage/'.$seccion->imagen) }}" width="300">
    @endif

    <hr>

    <h4>Archivos adicionales</h4>
    @forelse($seccion->archivos as $archivo)
        <a href="{{ asset('storage/'.$archivo) }}" target="_blank">📎 Archivo</a><br>
    @empty
        <p class="text-muted">Sin archivos</p>
    @endforelse

    <hr>

    <h4>Cuadro tipo tabla</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Título</th>
                <th>Autor</th>
                <th>Archivo</th>
                <th>Mostrar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($seccion->cuadros as $c)
            <tr>
                <td>{{ $c->titulo }}</td>
                <td>{{ $c->autor }}</td>
                <td>
                    @if($c->archivo)
                        <a href="{{ asset('storage/'.$c->archivo) }}" target="_blank">📄 Ver archivo</a>
                    @endif
                </td>
                <td>{{ $c->mostrar ? 'Sí' : 'No' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
