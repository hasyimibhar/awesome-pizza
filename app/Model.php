<?php

namespace AwesomePizza;

use Illuminate\Contracts\Support\Arrayable;

class Model implements Arrayable
{
    /**
     * Model id.
     *
     * @var int
     */
    public $id;

    /**
     * Creation timestamp.
     *
     * @var string
     */
    public $created_at;

    /**
     * Last update timestamp.
     *
     * @var string
     */
    public $updated_at;

    /**
     * Creates a new instance of the model.
     *
     * @param array $attributes
     */
    public function __construct($attributes = [])
    {
        foreach ($attributes as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return (array)$this;
    }
}
