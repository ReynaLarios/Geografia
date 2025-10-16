@extends('base.layout')

 @section('contenido')

<section class="bg-gray-50 dark:bg-gray-900 py-3 sm:py-5">
    <div class="px-4 mx-auto max-w-screen-2xl lg:px-12">
        <div class="relative overflow-hidden bg-white shadow-md dark:bg-gray-800 sm:rounded-lg p-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold">Lista de secciones</h3>
                <a href="/secciones/crear" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Agregar secciones
                </a>
            </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">ID</th>
                                <th scope="col" class="px-4 py-3">Nombre</th>
                                <th scope="col" class="px-4 py-3">Descripcion</th>
                            </tr>
                        </thead>
                        <tbody>

                           @foreach ($secciones as $secc)
                            <tr class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="px-4 py-3">{{ $secc->id }}</td>
                                <td class="px-4 py-3">{{ $secc->nombre}}</td>
                                <td class="px-4 py-3">{{ $secc->descripcion }}</td>
                                <td class="px-4 py-3">
                                </td>
                                <td class="px-4 py-3">
                                    <a href="/secciones/{{ $secc->id }}/editar" class="font-medium text-blue-600 dark:text-blue-500 hover:underline ml-2">Editar</a>
                                    <a href="/secciones/{{ $secc->id }}/mostrar" class="font-medium text-blue-600 dark:text-blue-500 hover:underline ml-2">Borrar</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection