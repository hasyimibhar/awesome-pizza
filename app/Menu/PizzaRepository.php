<?php

namespace AwesomePizza\Menu;

use AwesomePizza\Pizza;

class PizzaRepository implements PizzaRepositoryContract
{
    /**
     * Pizza model.
     *
     * @var \AwesomePizza\Pizza
     */
    protected $model;

    /**
     * Creates a new instance of PizzaRepository.
     *
     * @param \AwesomePizza\Pizza $model
     */
    public function __construct(Pizza $model)
    {
        $this->model = $model;
    }

    /**
     * Get all pizzas.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Get pizzas based on the given quantity and offset (for pagination).
     *
     * @param int $quantity
     * @param int $offset
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function take($quantity, $offset)
    {
        return $this->model->query()
            ->take($quantity)
            ->skip($offset * $quantity)
            ->get();
    }

    /**
     * Get a single pizza.
     *
     * @param int $pizzaId
     * @return \AwesomePizza\Pizza
     */
    public function find($pizzaId)
    {
        return $this->model->find($pizzaId);
    }
}
