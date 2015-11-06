<?php

use AwesomePizza\Http\Controllers\MenuController;
use AwesomePizza\Menu\PizzaRepositoryContract;
use \Mockery as m;
use Illuminate\Database\Eloquent\Collection;
use AwesomePizza\Pizza;

class MenuControllerTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testGetPizzasReturnsNoPizza()
    {
        $controller = new MenuController();
        $pizzaRepository = m::mock('AwesomePizza\Menu\PizzaRepositoryContract')
            ->shouldReceive('all')
            ->once()
            ->andReturn(new Collection())
            ->mock();

        $pizzas = $controller->getPizzas($pizzaRepository);

        verify($pizzas)->notNull();
        verify($pizzas->count())->equals(0);
    }

    public function testGetPizzasReturnsOnePizza()
    {
        $controller = new MenuController();
        $pizzaRepository = m::mock('AwesomePizza\Menu\PizzaRepositoryContract')
            ->shouldReceive('all')
            ->once()
            ->andReturn(new Collection([
                new Pizza(),
            ]))
            ->mock();

        $pizzas = $controller->getPizzas($pizzaRepository);

        verify($pizzas)->notNull();
        verify($pizzas->count())->equals(1);
    }

    public function testGetPizzasReturnsSomePizzas()
    {
        $controller = new MenuController();
        $pizzaRepository = m::mock('AwesomePizza\Menu\PizzaRepositoryContract')
            ->shouldReceive('all')
            ->once()
            ->andReturn(new Collection([
                new Pizza(),
                new Pizza(),
                new Pizza(),
                new Pizza(),
            ]))
            ->mock();

        $pizzas = $controller->getPizzas($pizzaRepository);

        verify($pizzas)->notNull();
        verify($pizzas->count())->equals(4);
    }
}
