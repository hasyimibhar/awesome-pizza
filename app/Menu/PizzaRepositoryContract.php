<?php

namespace AwesomePizza\Menu;

interface PizzaRepositoryContract
{
    /**
     * Get all pizzas.
     *
     * @return \Illuminate\Support\Collection
     */
    public function all();

    /**
     * Get pizzas based on the given quantity and offset (for pagination).
     *
     * @param int $quantity
     * @param int $offset
     * @return \Illuminate\Support\Collection
     */
    public function take($quantity, $offset);

    /**
     * Get a single pizza.
     *
     * @param int $pizzaId
     * @return \AwesomePizza\Menu\Pizza
     */
    public function find($pizzaId);
}
