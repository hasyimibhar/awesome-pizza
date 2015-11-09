<?php

namespace AwesomePizza\Menu;

use Illuminate\Database\ConnectionInterface as DatabaseConnectionContract;
use Illuminate\Support\Collection;

class CrustRepository implements CrustRepositoryContract
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
     * Get all crusts.
     *
     * @return \Illuminate\Support\Collection
     */
    public function all()
    {
        return with(new Collection($this->database->table('crusts')->get()))
            ->map(function ($attributes) {
                return new Crust($attributes);
            });
    }

    /**
     * Get a single crust.
     *
     * @param int $crustId
     * @return \AwesomePizza\Menu\Crust
     */
    public function find($crustId)
    {
        $row = $this->database->table('crusts')
            ->where('id', $crustId)
            ->first();

        if ($row != null) {
            return new Crust($row);
        } else {
            return null;
        }
    }
}
