@extends('base.layout')

@section('contenido')
<section class="bg-gray-50 dark:bg-gray-900 py-3 sm:py-5">
    <div class="px-4 mx-auto max-w-screen-lg lg:px-12">
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            @extends('base.layout')

<h2>Secciones disponibles</h2>
<p>Haz clic en una sección para ver su contenido.</p>



            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-2 rounded mb-3 text-center">
                    {{ session('success') }}
                </div>
            @endif

            <a href="{{ url('/secciones/crear') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Agregar nueva sección</a>

            <table class="w-full text-left border border-gray-300 mt-4">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-2">Nombre</th>
                        <th class="p-2">Descripción</th>
                        <th class="p-2 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($secciones as $seccion)
                        <tr class="border-t">
                            <td class="p-2">{{ $seccion->nombre }}</td>
                            <td class="p-2">{{ $seccion->descripcion }}</td>
                            <td class="p-2 text-center flex gap-2 justify-center">
                                <a href="{{ url('/secciones/'.$seccion->id.'/editar') }}" class="text-blue-600 hover:underline">Editar</a>
                                <form action="{{ route('secciones.borrar', $seccion->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta sección?')">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
