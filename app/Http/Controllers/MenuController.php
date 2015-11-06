<?php

namespace AwesomePizza\Http\Controllers;

use AwesomePizza\Menu\PizzaRepositoryContract;

class MenuController extends Controller
{
    /**
     * Get all available pizzas on the menu.
     *
     * @param \AwesomePizza\Menu\PizzaRepositoryContract $pizzas
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPizzas(PizzaRepositoryContract $pizzas)
    {
        return $pizzas->all();
    }
}
