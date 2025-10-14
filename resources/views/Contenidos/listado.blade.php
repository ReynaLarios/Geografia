@extends('base.layout')

 @section('contenido')

<section class="bg-gray-50 dark:bg-gray-900 py-3 sm:py-5">
    <div class="px-4 mx-auto max-w-screen-2xl lg:px-12">
        <div class="relative overflow-hidden bg-white shadow-md dark:bg-gray-800 sm:rounded-lg p-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold">Lista de contenidos</h3>
                <a href="/contenido/crear" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Agregar contenido
                </a>
            </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">ID</th>
                                <th scope="col" class="px-4 py-3">Titulo</th>
                                <th scope="col" class="px-4 py-3">Descripcion</th>
                                <th scope="col" class="px-4 py-3">Seccion</th>
                                <th scope="col" class="px-4 py-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contenidos as $cont)
                            <tr class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="px-4 py-3">{{ $cont->id }}</td>
                                <td class="px-4 py-3">{{ $cont->Titulo}}</td>
                                <td class="px-4 py-3">{{ $cont->descripcion }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center">
                                        <div class="h-2.5 w-2.5 rounded-full {{ $cont->estado=='ACTIVO'?'bg-green-500':'bg-red-500' }} me-2"></div>
                                        {{ $cont->estado }}
                                    </div>
                                </td>
                                <td class="px-4 py-3">{{ optional($cont->seccion)->nombre }}</td>
                                <td class="px-4 py-3">
                                    <a href="/contenidos/{{ $cont->id }}/editar" class="font-medium text-blue-600 dark:text-blue-500 hover:underline ml-2">Editar</a>
                                    <a href="/contenidos/{{ $cont->id }}/mostrar" class="font-medium text-blue-600 dark:text-blue-500 hover:underline ml-2">Borrar</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection