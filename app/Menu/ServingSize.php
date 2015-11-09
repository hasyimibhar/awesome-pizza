<?php

namespace AwesomePizza\Menu;

use AwesomePizza\Model;

class ServingSize extends Model
{
    /**
     * Serving size name.
     *
     * @var string
     */
    public $name;

    /**
     * Serving size price in cents.
     *
     * @var int
     */
    public $price;
}
