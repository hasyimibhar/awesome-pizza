<?php

namespace AwesomePizza\Menu;

use AwesomePizza\Model;

class Topping extends Model
{
    /**
     * Meat category.
     */
    const CATEGORY_MEAT = 1;

    /**
     * Seafood category.
     */
    const CATEGORY_SEAFOOD = 2;

    /**
     * Vegetable category.
     */
    const CATEGORY_VEGETABLE = 3;

    /**
     * Topping name.
     *
     * @var string
     */
    public $name;

    /**
     * Topping category.
     *
     * @var string
     */
    public $category;

    /**
     * Topping price in cents.
     *
     * @var int
     */
    public $price;
}
