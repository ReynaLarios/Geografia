@extends('base.layout')

@section('contenido')
<main class="p-4" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
    <h2 class="mb-3">{{ $contenido->titulo }}</h2>

    @if($contenido->imagen)
        <div class="mb-3">
            <img src="{{ asset('storage/'.$contenido->imagen) }}" alt="{{ $contenido->titulo }}" 
                 style="max-width: 250px; border-radius: 8px;">
        </div>
    @endif

    <div class="mb-3">
        <p>{{ $contenido->descripcion }}</p>
    </div>

    @if(isset($archivos) && count($archivos) > 0)
        <div class="card mt-3 shadow-sm mx-auto" style="width: 100%; max-width: 800px; border-radius: 6px;">
            <div class="card-header bg-primary text-white p-2">
                <h6 class="mb-0">Archivos asociados</h6>
            </div>
            <div class="card-body p-2">
                <ul class="list-unstyled mb-0">
                    @foreach($archivos as $archivo)
                        <li style="margin-bottom: 6px;">
                            <a href="{{ asset('storage/'.$archivo->ruta) }}" download
                               style="text-decoration: none; color: #007bff; font-size: 0.95em;">
                               📎 {{ $archivo->nombre }}
                               <span class="text-muted" style="font-size: 0.8em;">
                                   ({{ round(Storage::disk('public')->size($archivo->ruta)/1024/1024, 2) }} MB)
                               </span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @else
        <p class="text-muted mt-2">No hay archivos asociados a este contenido.</p>
    @endif
</main>
@endsection
