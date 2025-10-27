<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Administrador</title>
<link href="https://cdn.jsdelivr.net/npm/flowbite@3.0.0/dist/flowbite.min.css" rel="stylesheet" />
<style>
body {
    margin: 0;
    font: 600 16px/18px 'Open Sans', sans-serif;
    background: url('https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=1950&q=80') no-repeat center center fixed;
    background-size: cover;
    color: #fff;
}
*,:after,:before { box-sizing: border-box; }

.login-wrap { width: 100%; max-width: 525px; min-height: 670px; margin: auto; position: relative; }
.login-html { width: 100%; height: 100%; position: absolute; padding: 90px 70px 50px 70px; background: rgba(0, 0, 0, 0.6); box-shadow: 0 12px 15px 0 rgba(0,0,0,.24), 0 17px 50px 0 rgba(0,0,0,.19); border-radius: 10px; }
.login-html .sign-in-htm, .login-html .sign-up-htm{ top:0; left:0; right:0; bottom:0; position:absolute; transform:rotateY(180deg); backface-visibility:hidden; transition:all .4s linear; }
.login-html .sign-in, .login-html .sign-up, .login-form .group .check{ display:none; }
.login-html .tab, .login-form .group .label, .login-form .group .button{ text-transform:uppercase; }
.login-html .tab{ font-size:22px; margin-right:15px; padding-bottom:5px; margin:0 15px 10px 0; display:inline-block; border-bottom:2px solid transparent; }
.login-html .sign-in:checked + .tab, .login-html .sign-up:checked + .tab{ color:#fff; border-color:#1161ee; }
.login-form{ min-height:345px; position:relative; perspective:1000px; transform-style:preserve-3d; }
.login-form .group{ margin-bottom:15px; }
.login-form .group .label, .login-form .group .input, .login-form .group .button{ width:100%; color:#fff; display:block; }
.login-form .group .input, .login-form .group .button{ border:none; padding:15px 20px; border-radius:25px; background:rgba(255,255,255,.1); }
.login-form .group input[data-type="password"]{ text-security:circle; -webkit-text-security:circle; }
.login-form .group .button{ background:#1161ee; cursor:pointer; transition:.3s; }
.login-form .group label .icon{ width:15px; height:15px; border-radius:2px; position:relative; display:inline-block; background:rgba(255,255,255,.1); }
.login-form .group label .icon:before, .login-form .group label .icon:after{ content:''; width:10px; height:2px; background:#fff; position:absolute; transition:all .2s ease-in-out 0s; }
.login-form .group label .icon:before{ left:3px; width:5px; bottom:6px; transform:scale(0) rotate(0); }
.login-form .group label .icon:after{ top:6px; right:0; transform:scale(0) rotate(0); }
.login-form .group .check:checked + label{ color:#fff; }
.login-form .group .check:checked + label .icon{ background:#1161ee; }
.login-form .group .check:checked + label .icon:before{ transform:scale(1) rotate(45deg); }
.login-form .group .check:checked + label .icon:after{ transform:scale(1) rotate(-45deg); }
.login-html .sign-in:checked + .tab + .sign-up + .tab + .login-form .sign-in-htm{ transform:rotate(0); }
.login-html .sign-up:checked + .tab + .login-form .sign-up-htm{ transform:rotate(0); }
.hr{ height:2px; margin:60px 0 50px 0; background:rgba(255,255,255,.2); }
.foot-lnk{ text-align:center; }
.alert { padding: 15px; border-radius: 5px; margin-bottom: 20px; }
.alert-danger { background-color: rgba(255,0,0,.7); color: #fff; }
.alert-success { background-color: rgba(0,128,0,.7); color: #fff; }
</style>
</head>
<body>

<div class="login-wrap">
    <div class="login-html">

        <!-- Tabs -->
        <input id="tab-1" type="radio" name="tab" class="sign-in" checked>
        <label for="tab-1" class="tab">Iniciar Sesión</label>
        <input id="tab-2" type="radio" name="tab" class="sign-up">
        <label for="tab-2" class="tab">Registrarse</label>

        <div class="login-form">
            <!-- LOGIN -->
            <!-- LOGIN -->
<div class="sign-in-htm">
    <form action="{{ route('login.post') }}" method="POST">
        @csrf
        <div class="group">
            <label for="email" class="label">Correo electrónico</label>
            <input id="email" name="email" type="email" class="input" required value="{{ old('email') }}">
            <!-- Mensaje informativo debajo del input -->
            <small style="display:block; margin-top:5px; color: rgba(255,255,255,0.7); font-size: 12px;">
                Ingresa el correo con el que estás registrado
            </small>
        </div>
        <div class="group">
            <label for="password" class="label">Contraseña</label>
            <input id="password" name="password" type="password" class="input" data-type="password" required>
        </div>
        <div class="group">
            <input type="submit" class="button" value="Iniciar Sesión">
        </div>

        <!-- Línea divisoria -->
        <div class="hr"></div>
    </form>
</div>
<!-- Mensajes de éxito -->
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- Mensajes de error -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- REGISTRO -->
            <div class="sign-up-htm">
                <form action="{{ route('register.post') }}" method="POST">
                    @csrf
                    <div class="group">
                        <label for="email2" class="label">Correo electrónico</label>
                        <input id="email2" name="email" type="email" class="input" required value="{{ old('email') }}">
                    </div>
                    <div class="group">
                        <label for="pass" class="label">Contraseña</label>
                        <input id="pass" name="password" type="password" class="input" data-type="password" required>
                    </div>
                    <div class="group">
                        <label for="pass2" class="label">Repite tu contraseña</label>
                        <input id="pass2" name="password_confirmation" type="password" class="input" data-type="password" required>
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
