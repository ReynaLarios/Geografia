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

    @if($banner?->imagen)
        <div class="mb-4">
            <p>Imagen actual: {{ $banner->imagen }}</p>
            <img src="{{ asset('storage/banners/' . $banner->imagen) }}" class="img-fluid mb-3" alt="Banner">
            
            <form action="{{ route('banner.borrar') }}" method="POST" onsubmit="return confirm('¿Eliminar banner actual?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">🗑 Eliminar Banner</button>
            </form>
        </div>
    @endif

    <form action="{{ route('banner.actualizar') }}" method="POST" enctype="multipart/form-data" class="border p-4 rounded bg-white shadow-sm">
        @csrf
        <div class="mb-3">
            <label class="form-label">Subir nueva imagen</label>
            <input type="file" name="imagen" class="form-control" required>
            @error('imagen')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">💾 Actualizar Banner</button>
    </form>
</div>
@endsection
