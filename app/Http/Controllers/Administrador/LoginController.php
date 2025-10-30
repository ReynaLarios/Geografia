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
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = Administrador::where('email', $request->email)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            $request->session()->put('administrador_id', $admin->id);
            return redirect()->route('dashboard'); 
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas'])->withInput();
    }

  
    public function showRegisterForm()
    {
        return view('administrador.register');
    }

   
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
    public function logout(Request $request)
    {
        $request->session()->forget('administrador_id');
        return redirect()->route('login.form');
    }
}
