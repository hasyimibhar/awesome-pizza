<?php

namespace AwesomePizza\Menu;

interface ToppingRepositoryContract
{
    /**
     * Get all toppings.
     *
     * @return \Illuminate\Support\Collection
     */
    public function all();

    /**
     * Get a single topping.
     *
     * @param int $toppingId
     * @return \AwesomePizza\Menu\Topping
     */
    public function find($toppingId);
}
