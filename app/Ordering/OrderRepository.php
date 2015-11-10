<?php

namespace AwesomePizza\Ordering;

use Illuminate\Database\ConnectionInterface as DatabaseConnectionContract;
use Illuminate\Support\Collection;

class OrderRepository implements OrderRepositoryContract
{
    /**
     * Database connection.
     *
     * @var \Illuminate\Database\ConnectionInterface
     */
    protected $database;

    /**
     * Creates a new instance of CrustRepository.
     *
     * @param \Illuminate\Database\ConnectionInterface $database
     */
    public function __construct(DatabaseConnectionContract $database)
    {
        $this->database = $database;
    }

    /**
     * Get a single order of a cart.
     *
     * @param \AwesomePizza\Cart $cart
     * @param int $orderId
     * @return \AwesomePizza\Ordering\Order
     */
    public function find(Cart $cart, $orderId)
    {
        $row = $this->database->table('orders')
            ->where('cart_id', $cart->id)
            ->where('id', $orderId)
            ->first();

        if ($row != null) {
            return new Order($row);
        } else {
            return null;
        }
    }

    /**
     * Creates a new order for a cart.
     *
     * @param \AwesomePizza\Cart $cart
     * @param array $data
     * @return \AwesomePizza\Ordering\Order
     */
    public function create(Cart $cart, $data)
    {
        $id = $this->database->table('orders')
            ->insertGetId(array_merge($data, ['cart_id' => $cart->id]));

        return $this->find($cart, $id);
    }

    /**
     * Updates the order.
     *
     * @param \AwesomePizza\Ordering\Order $order
     * @param array $data
     * @return void
     */
    public function update(Order $order, $data)
    {
        $this->database->table('orders')->update($data);
    }

    /**
     * Deletes the order.
     *
     * @param \AwesomePizza\Ordering\Order $order
     * @return void
     */
    public function delete(Order $order)
    {
        $this->database->table('orders')
            ->where('id', $order->id)
            ->delete();
    }
}
