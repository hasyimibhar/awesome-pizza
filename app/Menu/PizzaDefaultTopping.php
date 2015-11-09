<?php

namespace AwesomePizza\Menu;

use AwesomePizza\Model;

class PizzaDefaultTopping extends Model
{
    /**
     * Pizza id.
     *
     * @var int
     */
    public $pizza_id;

    /**
     * Topping id.
     *
     * @var int
     */
    public $topping_id;
}
