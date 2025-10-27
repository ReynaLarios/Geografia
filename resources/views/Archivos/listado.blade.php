@extends('base.layout')

@section('contenido')
<h2>Archivos del contenido: {{ $contenido->titulo }}</h2>

<a href="{{ route('archivos.crear', $contenido->id) }}" class="btn btn-primary mb-3">Subir nuevo archivo</a>

<div class="row">
    @forelse($archivos as $archivo)
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                @if(in_array($archivo->tipo, ['jpg','jpeg','png','gif']))
                    <img src="{{ asset('storage/'.$archivo->ruta) }}" class="card-img-top" style="height:200px; object-fit:cover;">
                @elseif(in_array($archivo->tipo, ['mp4','avi','mov']))
                    <video controls class="w-100" style="height:200px; object-fit:cover;">
                        <source src="{{ asset('storage/'.$archivo->ruta) }}" type="video/{{ $archivo->tipo }}">
                    </video>
                @else
                    <div class="p-4 text-center">
                        <i class="bi bi-file-earmark-text fs-1"></i>
                        <p>{{ $archivo->nombre }}</p>
                    </div>
                @endif
                <div class="card-body text-center">
                    <a href="{{ route('archivos.descargar', $archivo->id) }}" class="btn btn-success btn-sm">Descargar</a>
                    <form action="{{ route('archivos.borrar', $archivo->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <p>No hay archivos subidos.</p>
    @endforelse
</div>
@endsection
