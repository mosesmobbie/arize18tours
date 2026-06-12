<?php

namespace App\Providers;

use Filament\Facades\Filament;
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
        Filament::serving(function (): void {
            config([
                'filament.brand' => 'Arize18',
                'filament.layout.footer.should_show_logo' => false,
            ]);

            Filament::registerStyles([
                'arize-filament-red' => asset('css/filament-red.css'),
            ]);
        });
    }
}
