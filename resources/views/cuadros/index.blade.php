@extends('base.layout')

@section('contenido')
<div class="container mt-4">

    <h2 class="mb-3"><strong>Cuadros</strong></h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('cuadros.guardar') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-3">
            <div class="col-md-4">
                <input type="text" name="titulo" class="form-control" placeholder="Título" required>
            </div>
            <div class="col-md-4">
                <input type="text" name="autor" class="form-control" placeholder="Autor">
            </div>
            <div class="col-md-3">
                <input type="file" name="archivo" class="form-control">
            </div>
            <div class="col-md-1 d-flex align-items-center">
                <button type="submit" class="btn btn-primary w-100">Agregar</button>
            </div>
        </div>
    </form>


    @if($cuadros->count() > 0)
        <div class="row mt-4">
            @foreach($cuadros as $cuadro)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $cuadro->titulo }}</h5>
                            <p class="card-text"><strong>Autor:</strong> {{ $cuadro->autor }}</p>

                            @if($cuadro->archivo)
                                <p>
                                    <a href="{{ asset('storage/'.$cuadro->archivo) }}" download="{{ $cuadro->nombre_real }}" class="btn btn-outline-primary w-100 mb-2">
                                        Descargar: {{ $cuadro->nombre_real }}
                                    </a>
                                    <small class="text-muted">
                                        Tamaño: {{ number_format(Storage::disk('public')->size($cuadro->archivo)/1024/1024, 2) }} MB
                                    </small>
                                </p>
                            @else
                                <p class="text-muted">No hay archivo adjunto</p>
                            @endif

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('cuadros.editar', $cuadro->id) }}" class="btn btn-warning w-50 me-1">Editar</a>
                                <form action="{{ route('cuadros.eliminar', $cuadro->id) }}" method="POST" class="w-50 ms-1">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger w-100" type="submit" onclick="return confirm('¿Seguro que deseas eliminar este cuadro?')">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>No hay cuadros agregados.</p>
    @endif
</div>
@endsection
