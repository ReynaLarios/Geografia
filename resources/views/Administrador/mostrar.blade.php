@extends('base.layout')

@section('contenido')
<div class="container mx-auto mt-10 p-4 text-white">
    <h2 class="text-2xl font-bold mb-4">Detalles del Administrador</h2>
    <p><strong>ID:</strong> {{ $administrador->id }}</p>
    <p><strong>Email:</strong> {{ $administrador->email }}</p>
        <p><strong>Password:</strong> {{ $administrador->password }}</p>
    <p><strong>Activo:</strong> {{ $administrador->activo ? 'Sí' : 'No' }}</p>
    <p><strong>Creado:</strong> {{ $administrador->created_at }}</p>
    <p><strong>Actualizado:</strong> {{ $administrador->updated_at }}</p>

    <a href="{{ route('administrador.listar') }}" class="bg-blue-600 px-4 py-2 rounded mt-4 inline-block">Volver</a>
</div>
@endsection
