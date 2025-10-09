@extends('base.layout')

@section('contenido')
<div class="container mt-4">

  <!-- ====== CARRUSEL ====== -->
  <div id="carouselNoticias" class="carousel slide mb-6" data-bs-ride="carousel">
    <div class="carousel-inner text-center">
      <div class="carousel-item active">
        <img src="{{ asset('geDones en geografía.png') }}" class="d-block mx-auto carousel-img" alt="Imagen 1">
      </div>
      <div class="carousel-item">
        <img src="{{ asset('geo.jpg') }}" class="d-block mx-auto carousel-img" alt="Imagen 2">
      </div>
      <div class="carousel-item">
        <img src="{{ asset('geo.jpg') }}" class="d-block mx-auto carousel-img" alt="Imagen 3">
      </div>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#carouselNoticias" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselNoticias" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Siguiente</span>
    </button>
  </div>

  <!-- ====== SECCIÓN DE NOTICIAS (SOLO TEXTO) ====== -->
  <div class="container">
    <h2 class="mb-4 text-center">Noticias</h2>
    <ul class="list-group" id="listaNoticias">
      <li class="list-group-item">Noticia 1: Noticia acerca de...</li>
      <li class="list-group-item d-none">Noticia 2: Noticia acerca de...</li>
      <li class="list-group-item d-none">Noticia 3: Noticia acerca de...</li>
      <li class="list-group-item d-none">Noticia 4: Noticia acerca de...</li>
    </ul>

    <!-- Botones para mostrar/ocultar más noticias -->
    <div class="text-center mt-3">
      <button id="btnMostrarMas" class="btn btn-outline-primary btn-sm">Agregar más</button>
      <button id="btnOcultar" class="btn btn-outline-secondary btn-sm d-none">Deshacer</button>
    </div>
  </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script para controlar cuántas noticias se ven -->
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const noticias = document.querySelectorAll("#listaNoticias li");
    const btnMostrarMas = document.getElementById("btnMostrarMas");
    const btnOcultar = document.getElementById("btnOcultar");

    let visibles = 1; // Solo una noticia al inicio
    const max = noticias.length;

    btnMostrarMas.addEventListener("click", () => {
      if (visibles < max) {
        noticias[visibles].classList.remove("d-none");
        visibles++;
      }
      if (visibles === max) {
        btnMostrarMas.classList.add("d-none");
      }
      btnOcultar.classList.remove("d-none");
    });

    btnOcultar.addEventListener("click", () => {
      if (visibles > 1) {
        visibles--;
        noticias[visibles].classList.add("d-none");
      }
      if (visibles === 1) {
        btnOcultar.classList.add("d-none");
      }
      btnMostrarMas.classList.remove("d-none");
    });
  });
</script>
@endsection
