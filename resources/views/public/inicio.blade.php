@extends('public.layout_public')

@section('contenido')
<div class="container text-center">
    <h1 class="mb-4 fw-bold text-primary">Licenciatura en Geografía</h1>
    <p class="lead mb-5">Bienvenido(a) al sitio oficial de la Licenciatura en Geografía del CUCSH, Universidad de Guadalajara.</p>

    <div class="row g-4 justify-content-center">
        @foreach($navbarSecciones ?? [] as $sec)
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body">
                    <h5 class="card-title fw-bold text-uppercase text-primary">{{ $sec->nombre }}</h5>
                    <p class="card-text text-muted">
                        {{ Str::limit(strip_tags($sec->descripcion ?? 'Sin descripción'), 100) }}
                    </p>
                    <a href="{{ route('public.verSeccion', $sec->id) }}" class="btn btn-outline-primary mt-2">Ver más</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

