<?php

namespace AwesomePizza\Menu;

interface PizzaDefaultToppingRepositoryContract
{
    /**
     * Get all default toppings for the specified pizza.
     *
     * @param \AwesomePizza\Menu\Pizza $pizza
     * @return \Illuminate\Support\Collection
     */
    public function all(Pizza $pizza);
}
