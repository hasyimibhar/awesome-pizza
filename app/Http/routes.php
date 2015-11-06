<?php

$router = app('router');

$router->get('menu/pizzas', 'MenuController@getPizzas');
$router->get('menu/pizzas/{pizzaId}', 'MenuController@getPizza');
$router->get('menu/crusts', 'MenuController@getCrusts');
$router->get('menu/crusts/{crustId}', 'MenuController@getCrust');
$router->get('menu/sizes', 'MenuController@getServingSizes');
$router->get('menu/sizes/{sizeId}', 'MenuController@getServingSize');
$router->get('menu/toppings', 'MenuController@getToppings');
$router->get('menu/toppings/{toppingId}', 'MenuController@getTopping');
