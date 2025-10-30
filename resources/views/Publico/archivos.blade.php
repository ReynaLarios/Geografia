<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archivos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4 text-center">Archivos Disponibles</h2>

    @if ($archivos->isEmpty())
        <p class="text-center">No hay archivos disponibles por el momento.</p>
    @else
        <div class="row">
            @foreach($archivos as $archivo)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $archivo->nombre }}</h5>
                        <p class="card-text">
                            <strong>Tipo:</strong> {{ strtoupper($archivo->tipo) }} <br>
                            @if($archivo->contenido)
                                <strong>Contenido:</strong> {{ $archivo->contenido->titulo }}
                            @endif
                        </p>
                        <a href="{{ asset('storage/' . $archivo->ruta) }}" target="_blank" class="btn btn-primary w-100">
                            Ver o Descargar
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

</body>
</html>
