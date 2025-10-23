<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminAuthController extends Controller
{
    public function form (){
        return view('Administrador/login');
}

public function in(Request $request)
{
    if (Auth::attempt([
        'usuario' => $request-> usuario,
        'password' => $request->password,
         'email' => $request->email
    ])){

        $request->session()->regenerate();
        return redirect('/panel');//intended('dashboard');
    }

    return back()->withErrors([
        'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
    ])->onlyInput('email');
}
public function out(Request $request){

Auth::logout();

$request->session()->invalidate();
$request->session()->regenerateToken();

return redirect('/');
}

}

