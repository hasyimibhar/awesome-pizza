<?php

namespace AwesomePizza\Http\Controllers;

use Illuminate\Http\Request;
use AwesomePizza\Menu\PizzaRepositoryContract;
use AwesomePizza\Menu\CrustRepositoryContract;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * Get a single pizza on the menu.
     *
     * @param \AwesomePizza\Menu\PizzaRepositoryContract $pizzaRepository
     * @param int $pizzaId
     * @return \AwesomePizza\PIzza
     */
    public function getPizza(PizzaRepositoryContract $pizzaRepository, $pizzaId)
    {
        $pizza = $pizzaRepository->find($pizzaId);

        if ($pizza != null) {
            return $pizza;
        } else {
            throw new NotFoundHttpException();
        }
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

    /**
     * Get a single crust on the menu.
     *
     * @param \AwesomePizza\Menu\CrustRepositoryContract $crustRepository
     * @param int $crustId
     * @return \AwesomePizza\Crust
     */
    public function getCrust(CrustRepositoryContract $crustRepository, $crustId)
    {
        $crust = $crustRepository->find($crustId);

        if ($crust != null) {
            return $crust;
        } else {
            throw new NotFoundHttpException();
        }
    }
}
