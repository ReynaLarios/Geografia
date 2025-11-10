@extends('base.layout')

@section('contenido')
<div class="container mt-4">
    <h2>Secciones</h2>
    <ul class="list-group mt-3">
        @foreach($secciones as $sec)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{ route('secciones.mostrar', $sec->id) }}">
                    {{ $sec->nombre }}
                </a>
                <div class="d-flex gap-2">
                    <a href="{{ route('navbar.secciones.editar', $sec->id) }}" class="btn btn-sm btn-outline-primary">✎</a>
                    <form action="{{ route('navbar.secciones.borrar', $sec->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger" type="submit">🗑</button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
</div>
@endsection
