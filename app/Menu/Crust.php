<?php

namespace AwesomePizza\Menu;

use AwesomePizza\Model;

class Crust extends Model
{
    /**
     * Crust name.
     *
     * @var string
     */
    public $name;

    /**
     * Crust price in cents.
     *
     * @var int
     */
    public $price;
}
