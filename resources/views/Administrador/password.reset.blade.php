<form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <input type="email" name="email" class="form-control mb-3" placeholder="Tu correo" required>
    <input type="password" name="password" class="form-control mb-3" placeholder="Nueva contraseña" required>
    <input type="password" name="password_confirmation" class="form-control mb-3" placeholder="Confirma tu contraseña" required>
    <button type="submit" class="btn btn-success w-100">Actualizar contraseña</button>
</form>
