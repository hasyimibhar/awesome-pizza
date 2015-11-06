<?php

namespace AwesomePizza\Http\Controllers;

use Illuminate\Http\Request;
use AwesomePizza\Menu\PizzaRepositoryContract;
use AwesomePizza\Menu\CrustRepositoryContract;
use AwesomePizza\Menu\ServingSizeRepositoryContract;
use AwesomePizza\Menu\ToppingRepositoryContract;
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
     * @return \AwesomePizza\Menu\Pizza
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
     * @return \AwesomePizza\Menu\Crust
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

    /**
     * Get all possible serving sizes on the menu.
     *
     * @param \AwesomePizza\Menu\ServingSizeRepositoryContract $servingSizeRepository
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getServingSizes(ServingSizeRepositoryContract $servingSizeRepository)
    {
        return $servingSizeRepository->all();
    }

    /**
     * Get a single serving size on the menu.
     *
     * @param \AwesomePizza\Menu\ServingSizeRepositoryContract $servingSizeRepository
     * @param int $sizeId
     * @return \AwesomePizza\Menu\ServingSize
     */
    public function getServingSize(ServingSizeRepositoryContract $servingSizeRepository, $sizeId)
    {
        $size = $servingSizeRepository->find($sizeId);

        if ($size != null) {
            return $size;
        } else {
            throw new NotFoundHttpException();
        }
    }

    /**
     * Get all possible toppings on the menu.
     *
     * @param \AwesomePizza\Menu\ToppingRepositoryContract $toppingRepository
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getToppings(ToppingRepositoryContract $toppingRepository)
    {
        return $toppingRepository->all();
    }

    /**
     * Get a single topping on the menu.
     *
     * @param \AwesomePizza\Menu\ToppingRepositoryContract $toppingRepository
     * @param int $toppingId
     * @return \AwesomePizza\Menu\Topping
     */
    public function getTopping(ToppingRepositoryContract $toppingRepository, $toppingId)
    {
        $topping = $toppingRepository->find($toppingId);

        if ($topping != null) {
            return $topping;
        } else {
            throw new NotFoundHttpException();
        }
    }
}
