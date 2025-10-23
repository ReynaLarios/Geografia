<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Geografía</title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.0.0/dist/flowbite.min.css" rel="stylesheet" />
    <style>
        body {
            margin: 0;
            font: 600 16px/18px 'Open Sans', sans-serif;
            background: url('https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=1950&q=80') 
                        no-repeat center center fixed;
            background-size: cover;
            color: #fff;
        }

        *,:after,:before { box-sizing: border-box; }

        .login-wrap {
            width: 100%;
            max-width: 525px;
            min-height: 670px;
            margin: auto;
            position: relative;
        }

        .login-html {
            width: 100%;
            height: 100%;
            position: absolute;
            padding: 90px 70px 50px 70px;
            background: rgba(0, 0, 0, 0.6); /* Fondo semi-transparente */
            box-shadow: 0 12px 15px 0 rgba(0,0,0,.24), 0 17px 50px 0 rgba(0,0,0,.19);
            border-radius: 10px;
        }

        .login-html .sign-in-htm,
        .login-html .sign-up-htm{
            top:0;
            left:0;
            right:0;
            bottom:0;
            position:absolute;
            transform:rotateY(180deg);
            backface-visibility:hidden;
            transition:all .4s linear;
        }

        .login-html .sign-in,
        .login-html .sign-up{
            display:none;
        }

        .login-html .tab{
            font-size:22px;
            margin-right:15px;
            padding-bottom:5px;
            display:inline-block;
            border-bottom:2px solid transparent;
            cursor: pointer;
        }

        .login-html .sign-in:checked + .tab,
        .login-html .sign-up:checked + .tab{
            color:#fff;
            border-color:#1161ee;
        }

        .login-form{
            min-height:345px;
            position:relative;
            perspective:1000px;
            transform-style:preserve-3d;
        }

        .login-form .group{
            margin-bottom:15px;
        }

        .login-form .group .label,
        .login-form .group .input,
        .login-form .group .button{
            width:100%;
            color:#fff;
            display:block;
        }

        .login-form .group .input{
            border:none;
            padding:15px 20px;
            border-radius:25px;
            background:rgba(255,255,255,.1);
        }

        .login-form .group input[data-type="password"]{
            -webkit-text-security:circle;
        }

        /* BOTONES MODERNOS */
        .login-form .group .button{
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            border-radius: 25px;
            padding: 15px 20px;
            border: none;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            transition: all 0.3s ease;
        }

        .login-form .group .button:hover{
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 10px 20px rgba(0,0,0,0.4);
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        .hr{
            height:2px;
            margin:60px 0 50px 0;
            background:rgba(255,255,255,.2);
        }

        .foot-lnk{
            text-align:center;
        } 
    </style>
</head>
<body>
<div class="login-wrap">
    <div class="login-html">
        <input id="tab-1" type="radio" name="tab" class="sign-in" checked>
        <label for="tab-1" class="tab">Iniciar Sesión</label>
        <input id="tab-2" type="radio" name="tab" class="sign-up">
        <label for="tab-2" class="tab">Registrate</label>

        <div class="login-form">

            <!-- INICIO DE SESION -->
            <div class="sign-in-htm">
                <form action="/login" method="POST">
                    <div class="group">
                        <label for="usuario" class="label">Usuario</label>
                        <input id="usuario" name="usuario" type="text" class="input" required>
                    </div>
                    <div class="group">
                        <label for="contraseña" class="label">Contraseña</label>
                        <input id="contraseña" name="contraseña" type="password" class="input" data-type="password" required>
                    </div>
                    <div class="group">
                        <input id="check" type="checkbox" class="check" checked>
                        <label for="check"><span class="icon"></span> Mantener sesión iniciada</label>
                    </div>
                    <div class="group">
                        <input type="submit" class="button" value="Iniciar Sesión">
                    </div>
                    <div class="hr"></div>
                    <div class="foot-lnk">
                        <a href="#forgot">¿Olvidaste tu contraseña?</a>
                    </div>
                </form>
            </div>

            <!-- REGISTRO -->
            <div class="sign-up-htm">
                <form action="/register" method="POST">
                    <div class="group">
                        <label for="user" class="label">Usuario</label>
                        <input id="user" name="usuario" type="text" class="input" required>
                    </div>
                    <div class="group">
                        <label for="pass" class="label">Contraseña</label>
                        <input id="pass" name="contraseña" type="password" class="input" data-type="password" required>
                    </div>
                    <div class="group">
                        <label for="pass2" class="label">Repite tu contraseña</label>
                        <input id="pass2" name="contraseña2" type="password" class="input" data-type="password" required>
                    </div>
                    <div class="group">
                        <label for="email" class="label">Correo electrónico</label>
                        <input id="email" name="email" type="email" class="input" required>
                    </div>
                    <div class="group">
                        <input type="submit" class="button" value="Registrate">
                    </div>
                    <div class="hr"></div>
                    <div class="foot-lnk">
                        <label for="tab-1">¿Ya eres miembro?</label>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flowbite@3.0.0/dist/flowbite.min.js"></script>
</body>
</html>
