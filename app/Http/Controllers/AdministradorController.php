<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\administrador;

class AdministradorController extends Controller
{
    public function index()
    {
        $administradores = Administrador::all();
        return view('administrador.index', compact('administradores'));
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'usuario' => ['required'],
            'contraseña' => ['required'],
            'email' => ['required']
        ]);

        if (Auth::attempt([
            'usuario' => $request->usuario,
            'contraseña' => $request->contraseña,
            'email' => $request->email
        ])) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'usuario' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('usuario');
    }

    public function crear()
    {
        return view('Administrador.administrador');
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'usuario' => 'required|unique:administradores',
            'contraseña' => 'required|min:6',
            'email'  =>'required|unique:administradores'
        ]);

        Administrador::crear([
            'usuario' => $request->usuario,
            'contraseña' => Hash::make($request->contraseña),
             'email' => $request->email,
        ]);

        return redirect()->route('administradores.listar')
            ->with('success', 'Administrador creado exitosamente');
    }

    public function listar()
    {
        $administradores = Administrador::all();
        return view('Administrador.listado', compact('administradores'));
    }

    public function editar($id)
    {
        $administrador = Administrador::findOrFail($id);
        return view('Administrador.editar', compact('administrador'));
    }

    public function actualizar(Request $request, $id)
    {
        $administrador = Administrador::findOrFail($id);
        
        $request->validate([
            'usuario' => 'required|unique:administradores,usuario,'.$id
        ]);

        $datos = [
            'usuario' => $request->usuario
        ];

        if ($request->filled('contraseña')) {
            $datos['contraseña'] = Hash::make($request->contraseña);
        }

         $request->validate([
            'email' => 'required|unique:administradores,email,'.$id
        ]);

        $datos = [
            'email' => $request->email
        ];

        $administrador->update($datos);

        return redirect()->route('administrador.listar')
            ->with('success', 'Administrador actualizado exitosamente');
    }

    public function borrar($id)
    {
        $administrador = Administrador::findOrFail($id);
        $administrador->delete();

        return redirect()->route('administrador.listar')
            ->with('success', 'Administrador eliminado exitosamente');
    }
}

