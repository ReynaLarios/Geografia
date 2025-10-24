@extends('base.layout')

@section('contenido')
<div class="container mx-auto mt-10 p-4">
    <h2 class="text-2xl font-bold mb-4 text-white">Lista de Administradores</h2>

    <a href="{{ route('administrador.login') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">Agregar Administrador</a>

    <table class="min-w-full bg-white rounded shadow overflow-hidden">
        <thead class="bg-gray-800 text-white">
            <tr>
                <th class="py-2 px-4">ID</th>
                <th class="py-2 px-4">Email</th>
                <th class="py-2 px-4">Password</th>
                <th class="py-2 px-4">Activo</th>
                <th class="py-2 px-4">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($administradores as $admin)
            <tr class="text-center border-b">
                <td class="py-2 px-4">{{ $admin->id }}</td>
                <td class="py-2 px-4">{{ $admin->email }}</td>
                <td class="py-2 px-4">{{ $admin->password }}</td>
                <td class="py-2 px-4">{{ $admin->activo ? 'Sí' : 'No' }}</td>
                <td class="py-2 px-4">
                    <a href="{{ route('administrador.{id}.mostrar', $admin->id) }}" class="text-green-600">Ver</a> |
                    <a href="{{ route('administrador.{id}.editar', $admin->id) }}" class="text-blue-600">Editar</a> |
                    <form action="{{ route('administrador.{id}.eliminar', $admin->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
