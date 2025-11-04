<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Administrador</title>
<link href="https://cdn.jsdelivr.net/npm/flowbite@3.0.0/dist/flowbite.min.css" rel="stylesheet" />
<style>
@import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap');

body {
    margin: 0;
    font-family: 'Open Sans', sans-serif;
    background: linear-gradient(rgba(30,58,138,0.6), rgba(96,165,250,0.6)),
                url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1950&q=80') 
                no-repeat center center fixed;
    background-size: cover;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
}

.login-wrap {
    width: 100%;
    max-width: 450px;
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(12px);
    border-radius: 15px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.3);
    padding: 50px 30px;
    position: relative;
}

.login-html {
    width: 100%;
}

.login-html .tab {
    font-size: 20px;
    margin-right: 15px;
    padding-bottom: 5px;
    display: inline-block;
    border-bottom: 2px solid transparent;
    cursor: pointer;
    transition: all 0.3s ease;
}

.login-html .sign-in:checked + .tab,
.login-html .sign-up:checked + .tab {
    color: #60a5fa;
    border-color: #60a5fa;
}

.login-form {
    margin-top: 30px;
}

.login-form .group {
    margin-bottom: 20px;
}

.login-form .input {
    width: 100%;
    padding: 15px 20px;
    border-radius: 30px;
    border: none;
    background: rgba(255,255,255,0.15);
    color: #fff;
    transition: background 0.3s ease;
}

.login-form .input:focus {
    background: rgba(255,255,255,0.3);
    outline: none;
}

.login-form .button {
    width: 100%;
    padding: 15px;
    border-radius: 30px;
    border: none;
    background: #60a5fa;
    color: #fff;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s ease, transform 0.2s;
}

.login-form .button:hover {
    background: #1e3a8a;
    transform: translateY(-2px);
}

.hr {
    height: 2px;
    margin: 40px 0;
    background: rgba(255,255,255,0.2);
    border: none;
}

.alert {
    padding: 12px;
    border-radius: 8px;
    margin-bottom: 15px;
}

.alert-danger {
    background-color: rgba(255,0,0,0.7);
    color: #fff;
}

.alert-success {
    background-color: rgba(0,128,0,0.7);
    color: #fff;
}

.login-html .sign-in-htm, .login-html .sign-up-htm {
    display: none;
}

.login-html input.sign-in:checked ~ .login-form .sign-in-htm,
.login-html input.sign-up:checked ~ .login-form .sign-up-htm {
    display: block;
}

.login-html .label {
    margin-bottom: 5px;
    font-size: 14px;
    color: rgba(255,255,255,0.8);
}
</style>
</head>
<body>

<div class="login-wrap">
    <div class="login-html">
        <input id="tab-1" type="radio" name="tab" class="sign-in" checked>
        <label for="tab-1" class="tab">Iniciar Sesión</label>
        <input id="tab-2" type="radio" name="tab" class="sign-up">
        <label for="tab-2" class="tab">Registrarse</label>

        <div class="login-form">
            <div class="sign-in-htm">
                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <div class="group">
                        <label for="email" class="label">Correo electrónico</label>
                        <input id="email" name="email" type="email" class="input" required value="{{ old('email') }}">
                        <small style="display:block; margin-top:5px; color: rgba(255,255,255,0.7); font-size: 12px;">
                            Ingresa el correo con el que estás registrado
                        </small>
                    </div>
                    <div class="group">
                        <label for="password" class="label">Contraseña</label>
                        <input id="password" name="password" type="password" class="input" required>
                    </div>
                    <div class="group">
                        <input type="submit" class="button" value="Iniciar Sesión">
                    </div>
                    <div class="hr"></div>
                </form>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="sign-up-htm">
                <form action="{{ route('register.post') }}" method="POST">
                    @csrf
                    <div class="group">
                        <label for="email2" class="label">Correo electrónico</label>
                        <input id="email2" name="email" type="email" class="input" required value="{{ old('email') }}">
                    </div>
                    <div class="group">
                        <label for="pass" class="label">Contraseña</label>
                        <input id="pass" name="password" type="password" class="input" required>
                    </div>
                    <div class="group">
                        <label for="pass2" class="label">Repite tu contraseña</label>
                        <input id="pass2" name="password_confirmation" type="password" class="input" required>
                    </div>
                    <div class="group">
                        <input type="submit" class="button" value="Registrarse">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flowbite@3.0.0/dist/flowbite.min.js"></script>
</body>
</html>

