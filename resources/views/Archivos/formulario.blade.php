@extends('base.layout')

@section('contenido')
<div class="container mt-4">
    <h2>Subir archivo al contenido: {{ $contenido->titulo ?? 'Sin título' }}</h2>

    {{-- Mensajes de error --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Mensaje de error de JS --}}
    <div id="msgError" class="alert alert-danger d-none"></div>

    {{-- Formulario --}}
    <form id="formSubida" action="{{ route('archivos.guardar', $contenido->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="archivo" class="form-label">Selecciona un archivo (máx. 10 MB)</label>
            <input type="file"
                   name="archivo"
                   id="archivo"
                   class="form-control"
                   accept=".jpg,.jpeg,.png,.gif,.mp4,.avi,.mov,.pdf,.doc,.docx,.txt"
                   required>
        </div>

        {{-- Barra de progreso --}}
        <div class="progress mb-3" style="height: 20px; display: none;">
            <div id="barraProgreso" class="progress-bar progress-bar-striped progress-bar-animated" 
                 role="progressbar" style="width: 0%">0%</div>
        </div>

        <button type="submit" class="btn btn-success">Subir</button>
        <a href="{{ route('archivos.listar', $contenido->id) }}" class="btn btn-secondary">Volver</a>
    </form>
</div>

{{-- Script --}}
<script>
const form = document.getElementById('formSubida');
const input = document.getElementById('archivo');
const msg = document.getElementById('msgError');
const progressContainer = document.querySelector('.progress');
const progressBar = document.getElementById('barraProgreso');

form.addEventListener('submit', (e) => {
    e.preventDefault();
    const archivo = input.files[0];

    // Validación de tamaño
    if (!archivo) return;
    const maxSizeMB = 10;
    const sizeMB = archivo.size / 1024 / 1024;
    msg.classList.add('d-none');

    if (sizeMB > maxSizeMB) {
        msg.textContent = `El archivo pesa ${(sizeMB).toFixed(2)} MB y el límite es ${maxSizeMB} MB.`;
        msg.classList.remove('d-none');
        return;
    }

    // Subida con barra de progreso
    const formData = new FormData(form);
    const xhr = new XMLHttpRequest();
    xhr.open('POST', form.action, true);
    xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

    // Mostrar barra
    progressContainer.style.display = 'block';
    progressBar.style.width = '0%';
    progressBar.textContent = '0%';

    xhr.upload.addEventListener('progress', (event) => {
        if (event.lengthComputable) {
            const porcentaje = Math.round((event.loaded / event.total) * 100);
            progressBar.style.width = porcentaje + '%';
            progressBar.textContent = porcentaje + '%';
        }
    });

    xhr.onload = () => {
        if (xhr.status === 200) {
            progressBar.classList.remove('bg-danger');
            progressBar.classList.add('bg-success');
            progressBar.textContent = '¡Completado!';
            setTimeout(() => {
                window.location.href = "{{ route('archivos.listar', $contenido->id) }}";
            }, 800);
        } else {
            msg.textContent = 'Ocurrió un error al subir el archivo.';
            msg.classList.remove('d-none');
            progressBar.classList.add('bg-danger');
        }
    };

    xhr.onerror = () => {
        msg.textContent = 'Error de conexión al subir el archivo.';
        msg.classList.remove('d-none');
    };

    xhr.send(formData);
});
</script>
@endsection
