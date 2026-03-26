<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Licencia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // 🔹 Configuración global de paginación y locale
        Paginator::useTailwind();
        App::setLocale('es');

        // 🔹 Compartir $licenciaBloqueada con todas las vistas
        View::composer('*', function ($view) {
            $licenciaBloqueada = false;

            if (Auth::check()) {
                $empresaId = Auth::user()->nit_empresa;

                if ($empresaId) {
                    $licenciaBloqueada = !Licencia::where('id_estado', 1)
                        ->whereDate('fecha_fin', '>=', now())
                        ->whereHas('pago', function ($query) use ($empresaId) {
                            $query->whereHas('admin', function ($q) use ($empresaId) {
                                $q->where('nit_empresa', $empresaId);
                            });
                        })
                        ->exists();
                }
            }

            $view->with('licenciaBloqueada', $licenciaBloqueada);
        });
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
}
