@extends('base.layout')

@section('contenido')
<div class="login-wrap">
    <div class="login-html">
        <input id="tab-2" type="radio" name="tab" class="sign-up" checked>
        <label for="tab-2" class="tab">Editar Administrador</label>
        <div class="login-form">
            <div class="sign-up-htm">
                <form action="{{ route('administrador.{id}.actualizar', $administrador->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="group">
                        <label for="email" class="label">Correo electrónico</label>
                        <input id="email" name="email" type="email" class="input" value="{{ $administrador->email }}" required>
                    </div>
                    <div class="group">
                        <label for="password" class="label">Contraseña</label>
                        <input id="password" name="password" type="password" class="input" data-type="password">
                        <small class="text-white">Dejar vacío si no quieres cambiarla</small>
                    </div>
                    <div class="group">
                        <label for="password_confirmation" class="label">Repetir Contraseña</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" class="input" data-type="password">
                    </div>
                    <div class="group">
                        <input type="submit" class="button" value="Actualizar">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
