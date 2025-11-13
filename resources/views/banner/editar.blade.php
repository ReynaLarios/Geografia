@extends('base.layout')

@section('contenido')
<div class="container mt-4">
    <h2>Editar Banner</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($banner && $banner->imagen)
        <div class="mb-3">
            <label>Imagen actual:</label><br>
            <img src="{{ asset('storage/banners/' . $banner->imagen) }}" alt="Banner" class="img-fluid" style="max-width: 300px;">
        </div>
    @endif

    <form action="{{ route('banner.actualizar') }}" method="POST" enctype="multipart/form-data" class="mb-3">
        @csrf
        <div class="mb-3">
            <label>Nueva imagen:</label>
            <input type="file" name="imagen" class="form-control" required>
            @error('imagen')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>

    <form action="{{ route('banner.borrar') }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger"
            onclick="return confirm('¿Seguro que quieres borrar el banner?')">
            Eliminar Banner
        </button>
    </form>
</div>
@endsection
