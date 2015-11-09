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

    /**
     * Get toppings with the specified ids.
     *
     * @param array $toppingIds
     * @return \Illuminate\Support\Collection
     */
    public function findMany($toppingIds);
}
