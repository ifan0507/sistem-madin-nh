<?php

namespace App\Providers;

use App\Models\PengaturanModel;
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
        View::composer('*', function ($view) {
            $pengaturanAktif = PengaturanModel::first();
            $view->with('pengaturanAktif', $pengaturanAktif);
        });
    }
}
