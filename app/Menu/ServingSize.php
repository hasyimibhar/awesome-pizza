<?php

namespace AwesomePizza\Menu;

use Illuminate\Database\Eloquent\Model;

class ServingSize extends Model
{
    protected $fillable = ['id', 'name', 'price'];
}
