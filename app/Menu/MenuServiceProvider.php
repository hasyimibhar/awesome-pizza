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
        $this->app->bind('AwesomePizza\Menu\CrustRepositoryContract', 'AwesomePizza\Menu\CrustRepository');
        $this->app->bind('AwesomePizza\Menu\ServingSizeRepositoryContract', 'AwesomePizza\Menu\ServingSizeRepository');
        $this->app->bind('AwesomePizza\Menu\ToppingRepositoryContract', 'AwesomePizza\Menu\ToppingRepository');
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
            'AwesomePizza\Menu\CrustRepositoryContract',
            'AwesomePizza\Menu\ServingSizeRepositoryContract',
            'AwesomePizza\Menu\ToppingRepositoryContract',
        ];
    }
}
