<?php

namespace AwesomePizza\Menu;

use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

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
        $this->app->bind('AwesomePizza\Menu\PizzaDefaultToppingRepositoryContract', 'AwesomePizza\Menu\PizzaDefaultToppingRepository');
        $this->app->bind('AwesomePizza\Menu\PizzaPriceCalculatorContract', 'AwesomePizza\Menu\PizzaPriceCalculator');
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
            'AwesomePizza\Menu\PizzaDefaultToppingRepositoryContract',
            'AwesomePizza\Menu\PizzaPriceCalculatorContract',
        ];
    }
}
