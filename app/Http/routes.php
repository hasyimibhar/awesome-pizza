<?php

$router = app('router');

$router->get('menu/pizzas', 'MenuController@getPizzas');
$router->get('menu/crusts', 'MenuController@getCrusts');
