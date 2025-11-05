@extends('base.layout')

@section('contenido')
<div class="container">
    <h2>Editar Banner</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('banner.actualizar') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Imagen actual:</label><br>
            @if($banner && $banner->imagen)
                <img src="{{ asset('storage/'.$banner->imagen) }}" alt="Banner" width="300">
            @endif
        </div>
        <div class="mb-3">
            <label>Subir nueva imagen:</label>
            <input type="file" name="imagen" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Banner</button>
    </form>

    <form action="{{ route('banner.borrar') }}" method="POST" class="mt-2">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger"
            onclick="return confirm('¿Seguro que quieres borrar el banner?')">
            Eliminar Banner
        </button>
    </form>
</div>
@endsection
