<?php

namespace AwesomePizza\Menu;

use Illuminate\Database\ConnectionInterface as DatabaseConnectionContract;
use Illuminate\Support\Collection;

class PizzaDefaultToppingRepository implements PizzaDefaultToppingRepositoryContract
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
     * Get all default toppings for the specified pizza.
     *
     * @param \AwesomePizza\Menu\Pizza $pizza
     * @return \Illuminate\Support\Collection
     */
    public function all(Pizza $pizza)
    {
        return with(new Collection($this->database->table('pizza_default_toppings')->get()))
            ->map(function ($attributes) {
                return new PizzaDefaultTopping($attributes);
            });
    }
}
