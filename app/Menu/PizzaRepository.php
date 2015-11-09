<?php

namespace AwesomePizza\Menu;

use Illuminate\Database\ConnectionInterface as DatabaseConnectionContract;
use Illuminate\Support\Collection;

class PizzaRepository implements PizzaRepositoryContract
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
     * Get all pizzas.
     *
     * @return \Illuminate\Support\Collection
     */
    public function all()
    {
        return with(new Collection($this->database->table('pizzas')->get()))
            ->map(function ($attributes) {
                return new Pizza($attributes);
            });
    }

    /**
     * Get pizzas based on the given quantity and offset (for pagination).
     *
     * @param int $quantity
     * @param int $offset
     * @return \Illuminate\Support\Collection
     */
    public function take($quantity, $offset)
    {
        return with(new Collection($this->database->table('pizzas')
                ->take($quantity)
                ->skip($offset * $quantity)
                ->get()))
            ->map(function ($attributes) {
                return new Pizza($attributes);
            });
    }

    /**
     * Get a single pizza.
     *
     * @param int $pizzaId
     * @return \AwesomePizza\Menu\Pizza
     */
    public function find($pizzaId)
    {
        $row = $this->database->table('pizzas')
            ->where('id', $pizzaId)
            ->first();

        if ($row != null) {
            return new Pizza($row);
        } else {
            return null;
        }
    }
}
