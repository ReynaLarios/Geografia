@extends('base.layout')

@section('contenido')
<section class="bg-gray-50 dark:bg-gray-900 py-3 sm:py-5">
    <div class="px-4 mx-auto max-w-screen-2xl lg:px-12">
        <div class="relative overflow-hidden bg-white shadow-md dark:bg-gray-800 sm:rounded-lg p-4">
            <div>
                <h3 class="text-xl font-semibold mb-4">Editar Administrador</h3>
                <form action="/administradores/{{ $administrador->id }}/actualizar" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Nombre</label>
                            <input type="text" name="nombre" value="{{ $administradores->nombre }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Apellido</label>
                            <input type="text" name="apellido" value="{{ $administradores->apellido }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                            <input type="email" name="email" value="{{ $administradores->email }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Imagen</label>
                            <input type="file" name="imagen" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Guardar</button>
                        <a href="/listar" class="bg-gray-500 text-white px-4 py-2 rounded-lg ml-2">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection