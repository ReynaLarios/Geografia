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
    public function boot(): void
    {
        View::composer('*', function ($view) {
            // Todas las secciones con sus contenidos normales
            $view->with('secciones', Seccion::with('contenidos')->get());

            // Navbar dinámico (secciones con sus submenús)
            $view->with('navbarSecciones', NavbarSeccion::with('contenidosNavbar')->get());

            // Banner más reciente
            $view->with('banner', Banner::latest()->first());
        });
    }
}




    




    



