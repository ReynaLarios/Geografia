@extends('base.layout')

@section('contenido')
<main class="p-4">
  <h1 class="text-2xl font-bold mb-4">Secciones</h1>
    <div class="row">
        @foreach($secciones as $secc)
            <div class="col-md-12 mb-4">
                <div class="card p-3">
                    <h3 class="card-title">{{ $secc->nombre }}</h3>
      </div>
        @endforeach
    </div>
</main>
@endsection

