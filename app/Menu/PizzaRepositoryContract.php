<?php

namespace AwesomePizza\Menu;

interface PizzaRepositoryContract
{
    /**
     * Get all pizzas.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * Get a single pizza.
     *
     * @param int $pizzaId
     * @return \AwesomePizza\Pizza
     */
    public function find($pizzaId);
}
