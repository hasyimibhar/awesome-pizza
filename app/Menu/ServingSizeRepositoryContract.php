<?php

namespace AwesomePizza\Menu;

interface ServingSizeRepositoryContract
{
    /**
     * Get all serving sizes.
     *
     * @return \Illuminate\Support\Collection
     */
    public function all();

    /**
     * Get a single serving size.
     *
     * @param int $sizeId
     * @return \AwesomePizza\Menu\ServingSize
     */
    public function find($sizeId);
}
