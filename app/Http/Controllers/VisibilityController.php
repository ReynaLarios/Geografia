<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VisibilityController extends Controller
{
    public function toggle(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'model' => 'required|string',
        ]);

        $modelClass = match($request->model) {
            'Seccion' => \App\Models\Seccion::class,
            'Contenido' => \App\Models\Contenidos::class,
            'NavbarSeccion' => \App\Models\NavbarSeccion::class,
            'NavbarContenido' => \App\Models\NavbarContenido::class,
            default => null,
        };

        if(!$modelClass) {
            return response()->json(['ok'=>false, 'message'=>'Modelo inválido'], 400);
        }

        $item = $modelClass::find($request->id);
        if(!$item) {
            return response()->json(['ok'=>false, 'message'=>'Item no encontrado'], 404);
        }

        $item->oculto_publico = !$item->oculto_publico;
        $item->save();

        return response()->json(['ok'=>true, 'oculto_publico'=>$item->oculto_publico]);
    }
}
