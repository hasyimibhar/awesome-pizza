<?php

namespace AwesomePizza\Ordering;

use AwesomePizza\User;
use Illuminate\Database\ConnectionInterface as DatabaseConnectionContract;
use Illuminate\Support\Collection;

class CartRepository implements CartRepositoryContract
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
     * Get a single cart of a user.
     *
     * @param \AwesomePizza\User $user
     * @param int $cartId
     * @return \AwesomePizza\Ordering\Cart
     */
    public function find(User $user, $cartId)
    {
        $row = $this->database->table('carts')
            ->where('user_id', $user->id)
            ->where('id', $cartId)
            ->first();

        if ($row != null) {
            return new Cart($row);
        } else {
            return null;
        }
    }

    /**
     * Creates a new cart for a user.
     *
     * @param \AwesomePizza\User $user
     * @return \AwesomePizza\Ordering\Cart
     */
    public function create(User $user)
    {
        $id = $this->database->table('carts')
            ->insertGetId([
                'user_id' => $user->id,
            ]);

        return $this->find($user, $id);
    }

    /**
     * Updates the cart.
     *
     * @param \AwesomePizza\Ordering\Cart $cart
     * @param array $data
     * @return void
     */
    public function update(Cart $cart, $data)
    {
        $this->database->table('carts')->update($data);
    }

    /**
     * Deletes the cart.
     *
     * @param \AwesomePizza\Ordering\Cart $cart
     * @return void
     */
    public function delete(Cart $cart)
    {
        $this->database->table('carts')
            ->where('id', $cart->id)
            ->delete();
    }
}
