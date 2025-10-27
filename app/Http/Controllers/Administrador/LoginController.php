<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Administrador;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    // Mostrar formulario de login
    public function showLoginForm()
    {
        return view('administrador.login');
    }

    // Procesar inicio de sesión
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = Administrador::where('email', $request->email)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            $request->session()->put('administrador_id', $admin->id);
            return redirect()->route('dashboard'); // asegúrate de tener esta ruta
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas'])->withInput();
    }

    // Mostrar formulario de registro
    public function showRegisterForm()
    {
        return view('administrador.register');
    }

    // Procesar registro
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:administradores,email',
            'password' => 'required|min:6|confirmed',
        ]);

        Administrador::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login.form')->with('success', 'Registro exitoso, ahora ingresa.');
    }

    // Cerrar sesión
    public function logout(Request $request)
    {
        $request->session()->forget('administrador_id');
        return redirect()->route('login.form');
    }
}
