<?php

namespace AwesomePizza\Menu;

use Illuminate\Database\Eloquent\Model;

class Topping extends Model
{
    const CATEGORY_MEAT = 1;
    const CATEGORY_SEAFOOD = 2;
    const CATEGORY_VEGETABLE = 3;
}
