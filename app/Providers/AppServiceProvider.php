<?php

namespace App\Providers;

// app/Providers/AppServiceProvider.php

use App\Models\Contenidos;
use App\Models\secciones;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\NavbarSeccion;
use App\Models\Banner;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */





public function boot()

{
   view()->composer('*', function ($view) {
        $view->with('secciones', Secciones::all());
        $view->with('navbarSecciones', NavbarSeccion::with('hijos')->get());
        $view->with('banner', Banner::latest()->first());
    });
}





    }




    
    



