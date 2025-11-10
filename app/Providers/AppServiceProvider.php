<?php

namespace App\Providers;



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
  
    view()->composer('*', function ($view) {

    
        $view->with('secciones', Seccion::with('contenidos')->get());

       
        $view->with('navbarSecciones', NavbarSeccion::with('contenidosNavbar')->get());

      
        $view->with('banner', Banner::latest()->first());
    });
}




    




    



}