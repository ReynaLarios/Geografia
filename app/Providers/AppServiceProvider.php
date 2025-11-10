<?php

namespace App\Providers;

// app/Providers/AppServiceProvider.php

use App\Models\Contenidos;
use App\Models\secciones;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\NavbarSeccion;
use App\Models\Banner;
use App\Models\Seccion;

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
    // Este composer se aplica a todas las vistas
    view()->composer('*', function ($view) {

        // Barra vertical
        $view->with('secciones', Seccion::with('contenidos')->get());

        // Barra horizontal (navbar)
        $view->with('navbarSecciones', NavbarSeccion::with('contenidosNavbar')->get());

        // Banner
        $view->with('banner', Banner::latest()->first());
    });
}




    




    



}