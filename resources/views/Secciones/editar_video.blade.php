@extends('base.layout')

@section('contenido')
<div class="container py-4">
    <h2 class="mb-4 text-center fw-bold text-primary">Editar video</h2>

    @if(session('exito'))
        <div class="alert alert-success text-center">{{ session('exito') }}</div>
    @endif

 
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

  
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('videoteca.actualizar', $video->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="titulo" class="form-label">Título del video</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" value="{{ $video->titulo }}" required>
                </div>

                <div class="mb-3">
                    <label for="url" class="form-label">URL del video</label>
                    <input type="url" class="form-control" id="url" name="url" value="{{ $video->url }}" required>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('videoteca') }}" class="btn btn-secondary">Regresar</a>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
