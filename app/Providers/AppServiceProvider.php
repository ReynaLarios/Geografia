<?php

namespace App\Providers;

// app/Providers/AppServiceProvider.php

use App\Models\Contenidos;
use App\Models\secciones;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
    // Comparte las secciones con todas las vistas
    View::composer('*', function ($view) {
        $view->with('secciones', Secciones::all());
    });
}



    }



    
    



