<h1>Página Pública</h1>
@foreach($secciones as $sec)
    <h3>{{ $sec->nombre }}</h3>
    <ul>
        @foreach($sec->contenidos as $cont)
            <li>{{ $cont->titulo }}</li>
        @endforeach
    </ul>
@endforeach