<?php

namespace AwesomePizza\Http\Controllers;

use Illuminate\Http\Request;
use AwesomePizza\Menu\PizzaRepositoryContract;
use AwesomePizza\Menu\CrustRepositoryContract;

class MenuController extends Controller
{
    /**
     * Default quantity of pizzas returned.
     */
    const PIZZAS_PER_PAGE = 10;

    /**
     * Get all available pizzas on the menu.
     *
     * @param \Illuminate\Http\Request $request
     * @param \AwesomePizza\Menu\PizzaRepositoryContract $pizzaRepository
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPizzas(
        Request $request,
        PizzaRepositoryContract $pizzaRepository
    ) {
        $quantity = $request->input('quantity', MenuController::PIZZAS_PER_PAGE);
        $offset = $request->input('offset', 0);

        if ($quantity <= 0 || !is_numeric($quantity)) {
            $quantity = MenuController::PIZZAS_PER_PAGE;
        }

        if ($offset <= 0 || !is_numeric($offset)) {
            $offset = 0;
        }

        return $pizzaRepository->take($quantity, $offset);
    }

    /**
     * Get all available crusts on the menu.
     *
     * @param \AwesomePizza\Menu\CrustRepositoryContract $crustRepository
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCrusts(CrustRepositoryContract $crustRepository)
    {
        return $crustRepository->all();
    }
}
