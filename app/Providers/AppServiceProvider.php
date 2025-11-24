<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Contenidos;
use App\Models\Seccion;
use App\Models\NavbarSeccion;
use App\Models\Banner;

class AppServiceProvider extends ServiceProvider
{
  
    public function register(): void
    {
        //
    }

   
    public function boot(): void
    {
        View::composer('*', function ($view) {
            
            $view->with('secciones', Seccion::with('contenidos')->get());

            $view->with('navbarSecciones', NavbarSeccion::with('contenidosNavbar')->get());

            
            $view->with('banner', Banner::latest()->first());
        });
    }
}




    




    



