@extends('base.layout')

@section('contenido')
<style>

.cuadros-box {
    background: linear-gradient(135deg, #eef5ff, #ffffff);
    padding: 20px;
    border-radius: 14px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.12);
    margin-top: 20px;
    border: 1px solid #d0e1ff;
}
.cuadros-box h5 { color: #0d3b66; font-weight: bold; margin-bottom: 15px; }
.table-cuadros thead { background: #dce9ff; color: #0b2f58; }
.table-cuadros td { padding: 12px; vertical-align: middle; }
.table-cuadros a { color: #0d47a1; font-weight: 600; }
.table-cuadros a:hover { text-decoration: underline; }
</style>

<main class="container mt-4">

    <h2 class="mb-4 text-center">{{ $seccion->nombre }}</h2>

  
    @if($seccion->imagen)
        <div class="mb-4 text-center">
            <img src="{{ asset('storage/'.$seccion->imagen) }}" class="img-fluid rounded shadow-sm" style="max-height:300px; object-fit:cover;">
        </div>
    @endif

   
    @if($seccion->descripcion)
        <div class="mb-4 p-3 bg-light rounded shadow-sm">{!! $seccion->descripcion !!}</div>
    @endif

   
@if($seccion->archivos && $seccion->archivos->count())
    <div class="mb-4">
        <ul class="list-group">
            @foreach($seccion->archivos as $archivo)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="{{ asset('storage/' . $archivo->ruta) }}" target="_blank">{{ $archivo->nombre }}</a>
                    <small class="text-muted">
                        @if($archivo->ruta && Storage::disk('public')->exists($archivo->ruta))
                            {{ number_format(Storage::disk('public')->size($archivo->ruta)/1024/1024, 2) }} MB
                        @else
                            0 MB
                        @endif
                    </small>
                </li>
            @endforeach
        </ul>
    </div>
@endif

  
   @if($seccion->cuadros && $seccion->cuadros->count())
    <div class="cuadros-box">

    
        <select id="filter-dropdown" class="form-select form-select-sm mb-2">
            <option value="all">Todos</option>
            @foreach(range('A','Z') as $letter)
                <option value="{{ $letter }}">{{ $letter }}</option>
            @endforeach
        </select>

        <table class="table table-cuadros">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Archivo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($seccion->cuadros->sortBy('titulo') as $cuadro)
                    <tr class="cuadro-item" data-letter="{{ strtoupper(substr($cuadro->titulo,0,1)) }}">
                        <td>{{ $cuadro->titulo }}</td>
                        <td>{{ $cuadro->autor ?? '-' }}</td>
                        <td>
                            @if($cuadro->archivos && $cuadro->archivos->count())
                                @foreach($cuadro->archivos as $archivo)
                                    <a href="{{ asset('storage/' . $archivo->ruta) }}" target="_blank">Ver archivo</a>
                                    <small class="text-muted">
                                        @if($archivo->ruta && Storage::disk('public')->exists($archivo->ruta))
                                            {{ number_format(Storage::disk('public')->size($archivo->ruta)/1024/1024, 2) }} MB
                                        @else
                                            0 MB
                                        @endif
                                    </small>
                                @endforeach
                            @else
                                <span class="text-muted">Sin archivo</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                <script>
                    
    document.addEventListener("DOMContentLoaded", function () {

    const rows = Array.from(document.querySelectorAll(".cuadro-item"));
    const filter = document.getElementById("filter-dropdown");
    const paginationBox = document.createElement("div");
    paginationBox.classList.add("mt-3");
    paginationBox.style.textAlign = "center";
    rows[0].closest("tbody").parentElement.appendChild(paginationBox);

    let itemsPerPage = 10; 

    function updateTable() {
        const selected = filter.value;
        let visibleRows = rows;

        if (selected !== "all") {
            visibleRows = rows.filter(row => row.dataset.letter === selected);
        }

        let totalPages = Math.ceil(visibleRows.length / itemsPerPage);
        let currentPage = window.currentPage || 1;

        if (currentPage > totalPages) currentPage = 1;
        window.currentPage = currentPage;

        rows.forEach(r => r.style.display = "none");

        let start = (currentPage - 1) * itemsPerPage;
        let end = start + itemsPerPage;
        visibleRows.slice(start, end).forEach(r => r.style.display = "");

        let html = "";
        for (let i = 1; i <= totalPages; i++) {
            html += `<button class="btn btn-sm ${i === currentPage ? 'btn-primary' : 'btn-outline-primary'} mx-1" onclick="window.currentPage=${i}; updateTable();">${i}</button>`;
        }

        paginationBox.innerHTML = html;
    }

    filter.addEventListener("change", () => {
        window.currentPage = 1;
        updateTable();
    });

    updateTable();

});
</script>
<script>
document.getElementById('filter-dropdown').addEventListener('change', function() {
    const selected = this.value;
    const rows = document.querySelectorAll('.cuadro-item');

    rows.forEach(row => {
        const letter = row.getAttribute('data-letter');

        if (selected === 'all' || letter === selected) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>

            </tbody>
        </table>
    </div>
@endif

   <div class="mt-3">
        <button class="fancy" onclick="window.history.back()">← Regresar</button>
    </div>
</main>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropdown = document.getElementById('filter-dropdown');
    const cuadros = document.querySelectorAll('.cuadro-item');

    dropdown.addEventListener('change', function() {
        const val = this.value;
        cuadros.forEach(c => {
            if(val === 'all' || c.dataset.letter === val) {
                c.style.display = 'table-row';
            } else {
                c.style.display = 'none';
            }
        });
    });
});
</script>
@endsection
