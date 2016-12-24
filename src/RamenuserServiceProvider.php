<?php namespace Ordent\Ramenuser;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\AliasLoader;
use Laravel\Passport\Passport;
use Laravel\Passport\Client;
class RamenuserServiceProvider extends ServiceProvider
{
  /**
   * Bootstrap the application services.
   *
   * @return void
   */
  public function boot()
  {
    Passport::routes();
    $this->publishes([
        __DIR__.'/ramenuser.php' => config_path('ramenuser.php'),
    ]);
    $this->loadRoutesFrom(__DIR__.'/routes.php');
  }
  /**
   * Register the application services.
   *
   * @return void
   */
  public function register(){
    $this->app->register(\Laravel\Passport\PassportServiceProvider::class);
    $this->app->register(\Kodeine\Acl\AclServiceProvider::class);
  }
}
