<?php

namespace App\Providers;

use App\View\Components\AppLayout;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerServices();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerViewComponents();
    }

    /**
     * Register view components.
     *
     * @return void
     */
    protected function registerViewComponents()
    {
        Blade::component('app-layout', AppLayout::class);
    }

    protected function registerServices()
    {
        $services = [
            'Contracts\Repositories\CustomerRepository' => 'Repositories\CustomerRepository',
        ];

        foreach ($services as $key => $value) {
            $this->app->singleton('App\\'.$key, 'App\\'.$value);
        }
    }
}
