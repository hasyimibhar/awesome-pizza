<?php

namespace AwesomePizza\Ordering;

use AwesomePizza\User;

interface CartRepositoryContract
{
    /**
     * Get a single cart of a user.
     *
     * @param \AwesomePizza\User $user
     * @param int $cartId
     * @return \AwesomePizza\Ordering\Cart
     */
    public function find(User $user, $cartId);

    /**
     * Creates a new cart for a user.
     *
     * @param \AwesomePizza\User $user
     * @return \AwesomePizza\Ordering\Cart
     */
    public function create(User $user);

    /**
     * Updates the cart.
     *
     * @param \AwesomePizza\Ordering\Cart $cart
     * @param array $data
     * @return void
     */
    public function update(Cart $cart, $data);

    /**
     * Deletes the cart.
     *
     * @param \AwesomePizza\Ordering\Cart $cart
     * @return void
     */
    public function delete(Cart $cart);
}
