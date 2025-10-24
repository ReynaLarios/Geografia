<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Administrador;
use Illuminate\Support\Facades\Hash;

class AdministradorController extends Controller
{
    // Aplica el middleware 'admin' a todas las rutas del controlador
    public function __construct()
    {
        $this->middleware('admin');
    }

    // Listar todos los administradores
    public function listar()
    {
        $administradores = Administrador::all();
        return view('administrador.listar', compact('administradores'));
    }

    // Mostrar formulario de crear administrador
    public function crear()
    {
        return view('administrador.crear');
    }

    // Guardar un nuevo administrador
    public function guardar(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:administradores,email',
            'contraseña' => 'required|min:6|confirmed',
        ]);

        Administrador::create([
            'email' => $request->email,
            'contraseña' => Hash::make($request->contraseña),
            'nombre' => $request->nombre ?? 'Admin Nuevo',
        ]);

        return redirect()->route('administrador.listar')->with('success', 'Administrador creado correctamente');
    }

    // Mostrar detalles de un administrador
    public function mostrar($id)
    {
        $administrador = Administrador::findOrFail($id);
        return view('administrador.mostrar', compact('administrador'));
    }

    // Mostrar formulario de edición
    public function editar($id)
    {
        $administrador = Administrador::findOrFail($id);
        return view('administrador.editar', compact('administrador'));
    }

    // Actualizar administrador
    public function actualizar(Request $request, $id)
    {
        $admin = Administrador::findOrFail($id);

        $request->validate([
            'email' => 'required|email|unique:administradores,email,' . $admin->id,
            'contraseña' => 'nullable|min:6|confirmed',
        ]);

        $admin->email = $request->email;
        if($request->contraseña){
            $admin->contraseña = Hash::make($request->contraseña);
        }
        $admin->save();

        return redirect()->route('administrador.listar')->with('success', 'Administrador actualizado correctamente');
    }

    // Eliminar administrador
    public function eliminar($id)
    {
        $admin = Administrador::findOrFail($id);
        $admin->delete();

        return redirect()->route('administrador.listar')->with('success', 'Administrador eliminado correctamente');
    }
}
