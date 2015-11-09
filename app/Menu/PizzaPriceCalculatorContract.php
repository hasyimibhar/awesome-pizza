<?php

namespace AwesomePizza\Menu;

use Illuminate\Support\Collection;

interface PizzaPriceCalculatorContract
{
    /**
     * Calculates the price of a pizza based on its serving size, crust, and toppings.
     *
     * @param \AwesomePizza\MenuServingSize $size
     * @param \AwesomePizza\MenuCrust $crust
     * @param \Illuminate\Support\Collection $toppings
     * @return int
     */
    public function calculate(ServingSize $size, Crust $crust, Collection $toppings);
}
