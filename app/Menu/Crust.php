<?php

namespace AwesomePizza\Menu;

use Illuminate\Database\Eloquent\Model;

class Crust extends Model
{
    protected $fillable = ['id', 'name', 'price'];
}
