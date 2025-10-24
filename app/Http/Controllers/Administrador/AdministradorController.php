<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Administrador;
use Illuminate\Support\Facades\Hash;

class AdministradorController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function listar()
    {
        $administradores = Administrador::all();
        return view('administrador.listado', compact('administradores'));
    }


    public function crear()
    {
        return view('administrador.login');
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:administradores,email',
            'password' => 'required|min:6|confirmed',
        ]);

        Administrador::create([
            'email' => $request->email,
            'password' => Hash::make($request->contraseña),
        ]);

        return redirect()->route('administrador.listado')->with('success', 'Administrador creado correctamente');
    }

    public function mostrar($id)
    {
        $administrador = Administrador::findOrFail($id);
        return view('administrador.mostrar', compact('administrador'));
    }

    public function editar($id)
    {
        $administrador = Administrador::findOrFail($id);
        return view('administrador.edicion', compact('administrador'));
    }

    public function actualizar(Request $request, $id)
    {
        $administrador = Administrador::findOrFail($id);

        $request->validate([
            'email' => 'required|email|unique:administradores,email,' . $administrador->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $administrador->email = $request->email;
        if($request->contraseña){
            $administrador->password = Hash::make($request->password);
        }
        $administrador->save();

        return redirect()->route('administrador.listado')->with('success', 'Administrador actualizado correctamente');
    }

    public function eliminar($id)
    {
        $administrador = Administrador::findOrFail($id);
        $administrador->delete();

        return redirect()->route('administrador.listado')->with('success', 'Administrador eliminado correctamente');
    }
}
