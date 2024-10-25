<?php

namespace Grvoyt\Niffler;

use Illuminate\Support\ServiceProvider;

class NifflerServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom($this->getConfigFile(), 'niffler');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    protected function getConfigFile(): string
    {
        return __DIR__ . '/../config/niffler.php';
    }
}
