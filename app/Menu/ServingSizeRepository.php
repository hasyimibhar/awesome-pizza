<?php

namespace AwesomePizza\Menu;

class ServingSizeRepository implements ServingSizeRepositoryContract
{
    /**
     * Serving size model.
     *
     * @var \AwesomePizza\Menu\ServingSize
     */
    protected $model;

    /**
     * Creates a new instance of ServingSizeRepository.
     *
     * @param \AwesomePizza\Menu\ServingSize $model
     */
    public function __construct(ServingSize $model)
    {
        $this->model = $model;
    }

    /**
     * Get all serving sizes.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Get a single serving size.
     *
     * @param int $sizeId
     * @return \AwesomePizza\Menu\ServingSize
     */
    public function find($sizeId)
    {
        return $this->model->find($sizeId);
    }
}
