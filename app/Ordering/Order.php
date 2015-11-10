<?php

namespace AwesomePizza\Ordering;

use AwesomePizza\Model;

class Order extends Model
{
    /**
     * Cart id.
     *
     * @var int
     */
    public $cart_id;

    /**
     * Pizza id.
     *
     * @var int
     */
    public $pizza_id;

    /**
     * Crust id.
     *
     * @var int
     */
    public $crust_id;

    /**
     * Size id.
     *
     * @var int
     */
    public $size_id;

    /**
     * Order quantity.
     *
     * @var int
     */
    public $quantity;
}
