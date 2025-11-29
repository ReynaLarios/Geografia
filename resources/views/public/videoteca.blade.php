@extends('public.layout')

@section('contenido')
<div class="container py-5">

    <h2 class="fw-bold mb-3 text-center text-primary"> Videoteca </h2>
   
    @if($videos->count() > 0)
        <div class="row">
            @foreach($videos as $video)
                @php
                    preg_match("/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/))([^\&\?\/]+)/", $video->url, $matches);
                    $youtube_id = $matches[1] ?? null;
                @endphp

                @if($youtube_id)
                <div class="col-md-4 mb-4">
                    <div class="card video-card border-0 shadow-sm h-100">
                        <div class="ratio ratio-16x9 video-thumb" 
                             data-bs-toggle="modal"
                             data-bs-target="#videoModal"
                             data-video="{{ $youtube_id }}"
                             style="cursor:pointer; position: relative;">
                            <img src="https://img.youtube.com/vi/{{ $youtube_id }}/hqdefault.jpg" 
                                 class="card-img-top rounded" alt="{{ $video->titulo }}">
                            <div class="overlay">
                                <i class="bi bi-play-circle-fill"></i>
                            </div>
                        </div>
                        <div class="card-body text-center">
                            <h5 class="fw-semibold">{{ $video->titulo }}</h5>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    @else
        <p class="text-center text-muted">No hay videos disponibles aún.</p>
    @endif

</div>
 <div class="mt-3">
        <button class="fancy" onclick="window.history.back()">← Regresar</button>
    </div>

<div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Reproduciendo Video</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-0">
        <div class="ratio ratio-16x9">
            <iframe id="iframeVideo" src="" frameborder="0" allowfullscreen></iframe>
        </div>
      </div>
    </div>
  </div>
</div>



<style>
.video-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.video-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
}
.video-thumb img {
    border-radius: 10px;
}
.overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.4);
    opacity: 0;
    transition: opacity 0.3s ease;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 10px;
}
.overlay i {
    font-size: 3rem;
    color: white;
}
.video-thumb:hover .overlay {
    opacity: 1;
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const videoModal = document.getElementById('videoModal');
    const iframe = document.getElementById('iframeVideo');

    videoModal.addEventListener('show.bs.modal', (event) => {
        const trigger = event.relatedTarget;
        const videoId = trigger.getAttribute('data-video');
        iframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1`;
    });

    videoModal.addEventListener('hidden.bs.modal', () => {
        iframe.src = "";
    });
});
</script>
@endsection
