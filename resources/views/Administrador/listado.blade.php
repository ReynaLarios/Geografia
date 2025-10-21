@extends('base.layout')

@section('contenido')
<section class="bg-gray-50 dark:bg-gray-900 py-3 sm:py-5">
    <div class="px-4 mx-auto max-w-screen-2xl lg:px-12">
        <div class="relative overflow-hidden bg-white shadow-md dark:bg-gray-800 sm:rounded-lg p-4">
            <div>
                <h3  href="/productos/crear"  class="text-xl font-semibold mb-4">Administradores Registrados</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">ID</th>
                                <th scope="col" class="px-4 py-3">Nombre</th>
                                <th scope="col" class="px-4 py-3">Apellido</th>
                                <th scope="col" class="px-4 py-3">Email</th>
                                <th scope="col" class="px-4 py-3">Password</th>
                                <th scope="col" class="px-4 py-3">Imagen1</th>
                                <th scope="col" class="px-4 py-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Administadores as $admi)
                            <tr class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="px-4 py-3">{{ $admi->id }}</td>
                                <td class="px-4 py-3">{{ $admi->nombre }}</td>
                                <td class="px-4 py-3">{{ $admi->apellido }}</td>
                                <td class="px-4 py-3">{{ $admi->email}}</td>
                                <td class="px-4 py-3">{{ $admi->password}}</td>
                                <td class="px-4 py-3">
                                    <img class="w-10 h-10 rounded-full" src="{{ $admi->imagen1 }}" alt="Imagen1">
                                </td>
                                </td>
                               
                                    <a href="/administradores/{{ $admi->id }}/editar" class="font-medium text-blue-600 dark:text-blue-500 hover:underline ml-2">Editar</a>
                                    <a href="/administradores/{{ $admi->id }}/mostrar" class="font-medium text-blue-600 dark:text-blue-500 hover:underline ml-2">Borrar</a>
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