<?php

namespace AwesomePizza\Menu;

use Illuminate\Database\ConnectionInterface as DatabaseConnectionContract;
use Illuminate\Support\Collection;

class ToppingRepository implements ToppingRepositoryContract
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
     * Get all toppings.
     *
     * @return \Illuminate\Support\Collection
     */
    public function all()
    {
        return with(new Collection($this->database->table('toppings')->get()))
            ->map(function ($attributes) {
                return new Topping($attributes);
            });
    }

    /**
     * Get a single topping.
     *
     * @param int $toppingId
     * @return \AwesomePizza\Menu\Topping
     */
    public function find($toppingId)
    {
        $row = $this->database->table('toppings')
            ->where('id', $toppingId)
            ->first();

        if ($row != null) {
            return new Topping($row);
        } else {
            return null;
        }
    }

    /**
     * Get toppings with the specified ids.
     *
     * @param array $toppingIds
     * @return \Illuminate\Support\Collection
     */
    public function findMany($toppingIds)
    {
        return with(new Collection($this->database->table('toppings')->whereIn('id', $toppingIds)->get()))
            ->map(function ($attributes) {
                return new Topping($attributes);
            });
    }
}
