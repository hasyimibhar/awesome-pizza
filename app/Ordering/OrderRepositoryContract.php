<?php

namespace AwesomePizza\Ordering;

interface OrderRepositoryContract
{
    /**
     * Get a single order of a cart.
     *
     * @param \AwesomePizza\Cart $cart
     * @param int $orderId
     * @return \AwesomePizza\Ordering\Order
     */
    public function find(Cart $cart, $orderId);

    /**
     * Creates a new order for a cart.
     *
     * @param \AwesomePizza\Cart $cart
     * @param array $data
     * @return \AwesomePizza\Ordering\Order
     */
    public function create(Cart $cart, $data);

    /**
     * Updates the order.
     *
     * @param \AwesomePizza\Ordering\Order $order
     * @param array $data
     * @return void
     */
    public function update(Order $order, $data);

    /**
     * Deletes the order.
     *
     * @param \AwesomePizza\Ordering\Order $order
     * @return void
     */
    public function delete(Order $order);
}
