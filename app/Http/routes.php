<?php

$router = app('router');

$router->get('menu/pizzas', 'MenuController@getPizzas');
$router->get('menu/pizzas/{pizzaId}', 'MenuController@getPizza');
$router->get('menu/crusts', 'MenuController@getCrusts');
$router->get('menu/crusts/{crustId}', 'MenuController@getCrust');
$router->get('menu/sizes', 'MenuController@getServingSizes');
