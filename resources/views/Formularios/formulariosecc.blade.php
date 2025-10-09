   


@section('contenido')
   @extends('base.layout')

<div class="container mt-5">
    <h2 class="mb-4 text-center">Editar Sección</h2>

    
        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Contenido asociado</label>
            <select name="contenido_id" class="form-select">
                
            </select>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary px-4">Actualizar Sección</button>
        </div>
    </form>
</div>
@endsection
