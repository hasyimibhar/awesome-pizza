<?php

namespace AwesomePizza;

use Illuminate\Database\Eloquent\Model;

class Pizza extends Model
{
    protected $fillable = ['id', 'name', 'price'];
}
