<?php
namespace Rafiur;
use Illuminate\Support\ServiceProvider;

class TaskManagerServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ .'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        
        $this->publishes([
            __DIR__.'/../database/seeders/SortingTableSeeder.php' => database_path('seeders/SortingTableSeeder.php')
        ], 'sorting-seeder');
    }
}
