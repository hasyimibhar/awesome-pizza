<?php

namespace AwesomePizza\Menu;

class ToppingRepository implements ToppingRepositoryContract
{
    /**
     * Topping model.
     *
     * @var \AwesomePizza\Menu\Topping
     */
    protected $model;

    /**
     * Creates a new instance of ToppingRepository.
     *
     * @param \AwesomePizza\Menu\Topping $model
     */
    public function __construct(Topping $model)
    {
        $this->model = $model;
    }

    /**
     * Get all toppings.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Get a single topping.
     *
     * @param int $toppingId
     * @return \AwesomePizza\Menu\Topping
     */
    public function find($toppingId)
    {
        return $this->model->find($toppingId);
    }
}
