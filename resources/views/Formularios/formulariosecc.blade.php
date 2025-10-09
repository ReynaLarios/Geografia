   


@section('contenido')
   @extends('base.layout')

<div class="container mt-5">
    <h2 class="mb-4 text-center">Editar Sección</h2>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <form action="{{ route('secc', $seccion->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $seccion->nombre) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" rows="3">{{ old('descripcion', $seccion->descripcion) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Contenido asociado</label>
            <select name="contenido_id" class="form-select">
                <option value="">-- Ninguno --</option>
                @foreach($contenidos as $contenido)
                    <option value="{{ $contenido->id }}" {{ $seccion->contenido_id == $contenido->id ? 'selected' : '' }}>
                        {{ $contenido->titulo }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary px-4">Actualizar Sección</button>
        </div>
    </form>
</div>
@endsection
