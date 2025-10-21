@extends('base.layout')

@section('contenido')
<main>
    <h2 class="text-xl font-semibold mb-4">
        {{ isset($contenido) ? 'Editar Contenido' : 'Crear Contenido' }}
    </h2>

    <form action="{{ isset($contenido) ? route('contenidos.update', $contenido->id) : route('contenidos.guardar') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($contenido))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" value="{{ $contenido->titulo ?? old('titulo') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" rows="5" required>{{ $contenido->descripcion ?? old('descripcion') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Sección</label>
            <select name="seccion_id" class="form-control" required>
                <option value="">Selecciona una sección</option>
                @foreach($secciones as $sec)
                    <option value="{{ $sec->id }}" {{ (isset($contenido) && $contenido->seccion_id == $sec->id) ? 'selected' : '' }}>
                        {{ $sec->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Imagen (opcional)</label>
            <input type="file" name="imagen" class="form-control">
            @if(isset($contenido) && $contenido->imagen)
                <img src="{{ asset('storage/' . $contenido->imagen) }}" alt="Imagen actual" class="mt-2 img-fluid" style="max-width:200px;">
            @endif
        </div>

        <button type="submit" class="fancy">{{ isset($contenido) ? 'Actualizar' : 'Crear' }}</button>
    </form>
</main>
@endsection
