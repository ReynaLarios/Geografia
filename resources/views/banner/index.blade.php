@extends('base.layout')

@section('contenido')
<div class="container mt-4">
    <h2 class="mb-4">Administrar Banner</h2>

    {{-- Mensajes de éxito o error --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(optional($banner)->imagen)
        <div class="mb-4">
            <p>Nombre de la imagen: {{ $banner->imagen }}</p>
           <img src="{{ asset('storage/' . ($banner?->imagen ?? '')) }}" class="banner" alt="Banner">


            <form action="{{ route('banner.borrar') }}" method="POST" onsubmit="return confirm('¿Eliminar banner actual?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger mt-3">🗑 Eliminar Banner</button>
            </form>
        </div>
    @endif

    {{-- Formulario para subir nuevo banner --}}
    <form action="{{ route('banner.guardar') }}" method="POST" enctype="multipart/form-data" class="border p-4 rounded bg-white shadow-sm">
        @csrf
        <div class="mb-3">
            <label class="form-label">Subir nuevo banner</label>
            <input type="file" name="imagen" class="form-control" required>
            @error('imagen')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">💾 Guardar</button>
    </form>
</div>
@endsection
