@extends('base.layout')

@section('contenido')
<main class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold" style="letter-spacing:.5px;">Listado de Secciones</h2>

        <a href="{{ route('secciones.crear') }}"
           class="btn btn-primary rounded-pill px-4 shadow-sm">
           + Crear Sección
        </a>
    </div>

    @if($secciones && $secciones->count() > 0)

        <div class="row g-4">
            @foreach($secciones as $seccion)
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm border-0 rounded-4 card-hover">
                        <div class="card-body d-flex flex-column">

                            
                            <h5 class="card-title fw-semibold text-primary">
                                {{ $seccion->nombre }}
                            </h5>

                          
                            @if($seccion->descripcion)
                                <p class="text-muted small mt-2">
                                    {{ Str::limit($seccion->descripcion, 80) }}
                                </p>
                            @endif

                           
                            @if($seccion->cuadros && $seccion->cuadros->count() > 0)
                                <span class="badge bg-light text-dark mt-1 px-3 py-2 rounded-pill shadow-sm w-fit">
                                    {{ $seccion->cuadros->count() }} cuadros
                                </span>
                            @else
                                <span class="badge bg-secondary-subtle text-dark mt-1 px-3 py-2 rounded-pill w-fit">
                                    Sin cuadros
                                </span>
                            @endif

                       
                            <div class="mt-auto pt-3 d-flex justify-content-between">

                                <a href="{{ route('secciones.mostrar', $seccion->slug) }}"
                                   class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                   Ver
                                </a>

                                <a href="{{ route('secciones.editar', $seccion->slug) }}"
                                   class="btn btn-outline-warning btn-sm rounded-pill px-3">
                                   Editar
                                </a>

                                <form action="{{ route('secciones.borrar', $seccion->slug) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('¿Seguro que quieres borrar esta sección?')">
                                        Borrar
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    @else
        <div class="text-center mt-5">
            <p class="text-muted fs-5">No hay secciones registradas.</p>
        </div>
    @endif

</main>

<style>
.card-hover {
    transition: .25s ease;
}
.card-hover:hover {
    transform: translateY(-6px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.12);
}
.w-fit {
    width: fit-content;
}
</style>

@endsection
