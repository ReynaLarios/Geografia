@extends('base.layout')

@section('contenido')
<main class="p-4">
    <h2 class="mb-4">Secciones</h2>

   
    @foreach($secciones as $seccion)
        <div class="mb-4">
            <h4>{{ $seccion->nombre }}</h4>
            <p>{{ $seccion->descripcion }}</p>
        </div>
    @endforeach


    <div class="text-center mt-5">
        <button class="btn btn-primary" id="mostrarVideotecaBtn">Mostrar Videoteca</button>
    </div>

    <div id="videotecaContainer" class="mt-4" style="display:none;">
        <h3>Videoteca</h3>
        @if(isset($videos) && $videos->count() > 0)
            <div class="row">
                @foreach($videos as $video)
                    @php
                        preg_match("/v=([^\&\?\/]+)/", $video->url, $matches);
                        $youtube_id = $matches[1] ?? null;
                    @endphp

                    @if($youtube_id)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                <img src="https://img.youtube.com/vi/{{ $youtube_id }}/hqdefault.jpg"
                                     class="card-img-top"
                                     style="cursor:pointer;"
                                     data-bs-toggle="modal"
                                     data-bs-target="#videoModal"
                                     data-video="{{ $youtube_id }}">
                                <div class="card-body">
                                    <h5>{{ $video->titulo }}</h5>
                                    <p>{{ $video->descripcion }}</p>
                                    <p><strong>Categoria:</strong> {{ $video->categoria->nombre }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            <p>No hay videos disponibles.</p>
        @endif
    </div>
</main>


<div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Reproduciendo Video</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="ratio ratio-16x9">
            <iframe id="iframeVideo" src="" frameborder="0" allowfullscreen></iframe>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('mostrarVideotecaBtn').addEventListener('click', function() {
    var container = document.getElementById('videotecaContainer');
    if(container.style.display === 'none') {
        container.style.display = 'block';
        this.textContent = 'Ocultar Videoteca';
    } else {
        container.style.display = 'none';
        this.textContent = 'Mostrar Videoteca';
    }
});

var videoModal = document.getElementById('videoModal');
videoModal.addEventListener('show.bs.modal', function (event) {
    var trigger = event.relatedTarget;
    var videoId = trigger.getAttribute('data-video');
    document.getElementById('iframeVideo').src = "https://www.youtube.com/embed/" + videoId + "?autoplay=1";
});

videoModal.addEventListener('hidden.bs.modal', function () {
    document.getElementById('iframeVideo').src = "";
});
</script>
@endsection
