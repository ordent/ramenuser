<?php

namespace Ordent\Ramenplatform;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
class RamenuserServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
        __DIR__.'ramen.php' => config_path('ramen.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(\Ordent\Ramenplatform\RamenplatformServiceProvider::class);
    }
}
