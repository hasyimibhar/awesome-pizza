<?php

namespace AwesomePizza\Menu;

use Illuminate\Database\Eloquent\Collection;

interface PizzaPriceCalculatorContract
{
    /**
     * Calculates the price of a pizza based on its serving size, crust, and toppings.
     *
     * @param \AwesomePizza\MenuServingSize $size
     * @param \AwesomePizza\MenuCrust $crust
     * @param \Illuminate\Database\Eloquent\Collection $toppings
     * @return int
     */
    public function calculate(ServingSize $size, Crust $crust, Collection $toppings);
}
