@extends('base.layout')

@section('contenido')
<div class="container mt-4">
  <h2 class="mb-4">Administrar Banner</h2>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @if($banner && $banner->imagen)
    <div class="mb-4">
      <img src="{{ asset('storage/' . $banner->imagen) }}" class="banner" alt="Banner">

    <form action="{{ route('banner.borrar') }}" method="POST" onsubmit="return confirm('¿Eliminar banner actual?')">
      @csrf
      @method('DELETE')
      <button class="btn btn-danger mb-4">🗑 Eliminar Banner</button>
    </form>
  @endif

  <form action="{{ route('banner.guardar') }}" method="POST" enctype="multipart/form-data" class="border p-4 rounded bg-white shadow-sm">
    @csrf
    <div class="mb-3">
      <label class="form-label">Subir nuevo banner</label>
      <input type="file" name="imagen" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">💾 Guardar</button>
  </form>
</div>
@endsection
