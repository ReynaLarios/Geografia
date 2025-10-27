<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=1950&q=80') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            background: rgba(0, 0, 0, 0.7);
            border: none;
            border-radius: 15px;
            padding: 30px;
            width: 400px;
            box-shadow: 0 0 10px rgba(255,255,255,0.2);
        }
        .btn-custom {
            background-color: #1161ee;
            color: #fff;
            border-radius: 25px;
        }
        .btn-custom:hover {
            background-color: #0e4fc6;
        }
    </style>
</head>
<body>

<div class="card text-center">
    <h3 class="mb-4">¿Olvidaste tu contraseña?</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
    @csrf
    <input type="email" name="email" class="form-control" placeholder="Tu correo" required>
    <button type="submit" class="btn btn-primary mt-3 w-100">Enviar enlace</button>
</form>

    <div class="mt-3">
        <a href="{{ route('login.form') }}" class="text-white text-decoration-none">← Volver al inicio de sesión</a>
    </div>
</div>

</body>
</html>
