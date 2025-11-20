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

    {{-- Mostrar banner actual --}}
    @if($banner?->imagen)
        <div class="mb-4">
            <p>Imagen actual: {{ $banner->imagen }}</p>
            <img src="{{ asset('storage/banners/' . $banner->imagen) }}" class="img-fluid mb-3" alt="Banner">
        </div>
    @endif

    {{-- Formulario para subir o actualizar banner --}}
    <form action="{{ route('banner.guardar') }}" method="POST" enctype="multipart/form-data" class="border p-4 rounded bg-white shadow-sm">
        @csrf
        <div class="mb-3">
            <label class="form-label">Subir nueva imagen</label>
            <input type="file" name="imagen" class="form-control" required>
            @error('imagen')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">💾 Guardar / Actualizar Banner</button>
    </form>
</div>
@endsection
