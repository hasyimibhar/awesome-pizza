<?php

namespace AwesomePizza\Menu;

use Illuminate\Database\ConnectionInterface as DatabaseConnectionContract;
use Illuminate\Support\Collection;

class ServingSizeRepository implements ServingSizeRepositoryContract
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
     * Get all serving sizes.
     *
     * @return \Illuminate\Support\Collection
     */
    public function all()
    {
        return with(new Collection($this->database->table('serving_sizes')->get()))
            ->map(function ($attributes) {
                return new ServingSize($attributes);
            });
    }

    /**
     * Get a single serving size.
     *
     * @param int $sizeId
     * @return \AwesomePizza\Menu\ServingSize
     */
    public function find($sizeId)
    {
        $row = $this->database->table('serving_sizes')
            ->where('id', $sizeId)
            ->first();

        if ($row != null) {
            return new ServingSize($row);
        } else {
            return null;
        }
    }
}
