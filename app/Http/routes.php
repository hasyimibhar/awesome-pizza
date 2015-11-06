<?php

$router = app('router');

$router->get('menu/pizzas', 'MenuController@getPizzas');
