<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function form (){
        return view('Administrador/login');
}

public function in(Request $request)
{
    if (Auth::attempt([
        'email' => $request-> email,
        'password' => $request->password
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

