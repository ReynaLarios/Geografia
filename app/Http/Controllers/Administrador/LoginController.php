<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Administrador;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('administrador.login');
    }

    public function login(Request $request)
    {
        $admin = Administrador::where('email', $request->email)->first();

        if ($admin && Hash::check($request->contraseña, $admin->contraseña)) {
            $request->session()->put('administrador_id', $admin->id);
            return redirect()->route('administrador.listar');
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas']);
    }

    public function showRegisterForm()
    {
        return view('administrador.login'); // usamos la misma vista, solo cambia el tab
    }

    public function register(Request $request)
    {
        // Validación básica
        $request->validate([
            'email' => 'required|email|unique:administradores,email',
            'contraseña' => 'required|min:6|confirmed',
        ], [
            'contraseña.confirmed' => 'Las contraseñas no coinciden'
        ]);

        $admin = Administrador::create([
            'email' => $request->email,
            'contraseña' => Hash::make($request->contraseña),
            'nombre' => 'Admin Nuevo', // opcional, podrías pedir nombre también
        ]);

        // Inicia sesión automáticamente
        $request->session()->put('administrador_id', $admin->id);

        return redirect()->route('administrador.listar');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('administrador_id');
        return redirect()->route('administrador.login');
    }
}
