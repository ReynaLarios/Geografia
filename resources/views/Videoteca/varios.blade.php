@extends('base.layout')

@section('contenido')
<div class="container mt-5">
  <h2 class="mb-4 text-center text-primary">Varios</h2>

  <div class="row">
    <div class="col-md-6 mb-4">
      <div class="ratio ratio-16x9">
        <iframe 
          src="https://www.youtube.com/embed/6tyoh1321PU" 
          title="Quierosergeografo1de2"
          frameborder="0"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
          allowfullscreen>
        </iframe>
      </div>
    </div>
  </div>
  <div class="text-center mt-4">
    <a href="{{ url('/videoteca') }}" class="btn btn-outline-secondary">Volver a Videoteca</a>
  </div>
</div>
  @endsection
