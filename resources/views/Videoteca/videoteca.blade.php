@extends('base.layout')

@section('contenido')
<div class="container mt-5">
  <h2 class="mb-4 text-center">Videoteca</h2>
  <p class="text-center">Selecciona una sección para ver los videos:</p>

  <div class="row justify-content-center">

    <!-- Sección Recientes -->
    <div class="col-md-5 mb-4">
      <a href="{{ url('/videoteca/recientes') }}" class="text-decoration-none">
        <div class="card shadow-lg border-0">
          <!-- Fondo de la tarjeta -->
          <div class="card-img-top bg-dark"
               style="background: url('https://www.youtube.com/embed/6tyoh1321PU') center/cover;
                      height: 200px; border-top-left-radius: .5rem; border-top-right-radius: .5rem;">
          </div>
          <div class="card-body text-center">
            <h4 class="text-black">Seminario de investigación</h4>
            <p class="text-muted"></p>
          </div>
        </div>
      </a>
    </div>

    <!-- Sección Populares -->
    <div class="col-md-5 mb-4">
      <a href="{{ url('/videoteca/populares') }}" class="text-decoration-none">
        <div class="card shadow-lg border-0">
          <!-- Fondo de la tarjeta -->
          <div class="card-img-top bg-dark"
               style="background: url('https://www.youtube.com/embed/6tyoh1321PU') center/cover;
                      height: 200px; border-top-left-radius: .5rem; border-top-right-radius: .5rem;">
          </div>
          <div class="card-body text-center">
            <h4 class="text-black">Varios</h4>
            <p class="text-muted"></p>
          </div>
        </div>
      </a>
    </div>

  </div>
</div>
@endsection
