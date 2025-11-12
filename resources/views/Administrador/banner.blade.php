@extends('base.admin')

@section('admin')
<h3>Banner del Administrador</h3>


@if($banner)
    <img src="{{ asset('storage/' . $banner->ruta) }}" alt="Banner Admin" class="img-fluid mb-2">
@endif


<form action="{{ route('archivos.guardarBannerAdmin') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="archivo" required>
    <button class="btn btn-primary">Subir / Cambiar Imagen</button>
</form>
@if($banner)
<form action="{{ route('archivos.borrar', $banner->id) }}" method="POST" class="mt-2">
    @csrf
    @method('DELETE')
    <button class="btn btn-danger">Eliminar Imagen</button>
</form>
@endif


@endsection
