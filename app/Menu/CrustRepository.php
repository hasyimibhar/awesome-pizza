<?php

namespace AwesomePizza\Menu;

use AwesomePizza\Crust;

class CrustRepository implements CrustRepositoryContract
{
    /**
     * Crust model.
     *
     * @var \AwesomePizza\Crust
     */
    protected $model;

    /**
     * Creates a new instance of CrustRepository.
     *
     * @param \AwesomePizza\Crust $model
     */
    public function __construct(Crust $model)
    {
        $this->model = $model;
    }

    /**
     * Get all crusts.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Get a single crust.
     *
     * @param int $crustId
     * @return \AwesomePizza\Crust
     */
    public function find($crustId)
    {
        return $this->model->find($crustId);
    }
}
