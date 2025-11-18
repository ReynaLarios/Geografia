@extends('public.layout')


@section('contenido')
<div class="container mt-4">
    

    @if($imagenes->count() > 0)
        <ul class="list-group">
            @foreach($imagenes as $img)
                <li class="list-group-item d-flex align-items-center">
                    <img src="{{ asset('storage/'.$img->imagen) }}" width="150" class="rounded me-3" alt="Imagen">
                    <span class="text-muted">Imagen #{{ $loop->iteration }}</span>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-center text-muted">No hay imágenes en el carrusel.</p>
    @endif
</div>

<style>
.list-group-item {
    background: #FFF3E6;
    border-color: #FFD5B8;
}
</style>
@endsection
