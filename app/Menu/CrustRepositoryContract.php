<?php

namespace AwesomePizza\Menu;

interface CrustRepositoryContract
{
    /**
     * Get all crusts.
     *
     * @return \Illuminate\Support\Collection
     */
    public function all();

    /**
     * Get a single crust.
     *
     * @param int $crustId
     * @return \AwesomePizza\Menu\Crust
     */
    public function find($crustId);
}
