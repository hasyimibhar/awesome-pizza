<?php

namespace AwesomePizza;

use Illuminate\Database\Eloquent\Model;

class Crust extends Model
{
    protected $fillable = ['id', 'name', 'price'];
}
