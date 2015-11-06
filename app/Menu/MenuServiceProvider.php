<?php

namespace AwesomePizza\Menu;

use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('AwesomePizza\Menu\PizzaRepositoryContract', 'AwesomePizza\Menu\PizzaRepository');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'AwesomePizza\Menu\PizzaRepositoryContract',
        ];
    }
}
