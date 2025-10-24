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
        $administrador = Administrador::where('email', $request->email)->first();

        if ($administrador && Hash::check($request->contraseña, $administrador->password)) {
           // Auth::login();
            $request->session()->put('administrador_id', $administrador->id);
            return redirect()->route('administrador.listado');
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas']);
    }

    public function showRegisterForm()
    {
        return view('administrador.login'); 
    }

    public function register(Request $request)
    {
      
        $request->validate([
            'email' => 'required|email|unique:administradores,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'password.confirmed' => 'Las contraseñas no coinciden'
        ]);

       $administrador = Administrador::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

      
        $request->session()->put('administrador_id',$administrador->id);

        return redirect()->route('administrador.listado');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('administrador_id');
        return redirect()->route('administrador.login');
    }
}
