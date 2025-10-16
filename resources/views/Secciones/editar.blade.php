@extends('base.layout')

@section('contenido')
<div class="container mt-5">
    <h2 class="mb-4 text-center">Editar Contenido</h2>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <form action="/secciones/{{ $seccion->id }}/actualizar" method="POST" enctype="multipart/form-data">
        @csrf
      @method ('PUT')

        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="Nombre" class="form-control" value="{{ old('nombre', $seccion->nombre) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" rows="3">{{ old('descripcion', $seccion->descripcion) }}</textarea>
        </div>

       

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary px-4">Actualizar Seccion</button>
        </div>
    </form>
</div>
@endsection
