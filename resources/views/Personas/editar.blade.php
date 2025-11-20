@extends('base.layout')

@section('contenido')
<div class="container mt-4">
    <h2>Editar Persona</h2>
    <form action="{{ route('personas.update', $persona->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $persona->nombre) }}">
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $persona->email) }}">
        </div>
        <div class="mb-3">
            <label>Datos Adicionales</label>
            <textarea name="datos_adicionales" class="form-control">{{ old('datos_adicionales', $persona->datos_adicionales) }}</textarea>
        </div>
        <div class="mb-3">
            <label>Foto</label>
            <input type="file" name="foto" class="form-control">
            @if($persona->foto)
                <img src="{{ asset('storage/' . $persona->foto) }}" width="100" class="mt-2">
            @endif
        </div>
        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('personas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
