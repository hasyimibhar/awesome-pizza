<?php

use AwesomePizza\Http\Controllers\MenuController;
use AwesomePizza\Menu\PizzaRepositoryContract;
use \Mockery as m;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use AwesomePizza\Pizza;

class MenuControllerTest extends \Codeception\TestCase\Test
{
    use Codeception\Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
        $this->specifyConfig()->deepClone(false);
    }

    public function testGetPizzasReturnsNoPizza()
    {
        $controller = new MenuController();
        $pizzaRepository = m::mock('AwesomePizza\Menu\PizzaRepositoryContract')
            ->shouldReceive('take')
            ->with(MenuController::PIZZAS_PER_PAGE, 0)
            ->once()
            ->andReturn(new Collection())
            ->mock();

        $pizzas = $controller->getPizzas(new Request(), $pizzaRepository);

        verify($pizzas)->notNull();
        verify($pizzas->count())->equals(0);
    }

    public function testGetPizzasReturnsOnePizza()
    {
        $controller = new MenuController();
        $pizzaRepository = m::mock('AwesomePizza\Menu\PizzaRepositoryContract')
            ->shouldReceive('take')
            ->with(MenuController::PIZZAS_PER_PAGE, 0)
            ->once()
            ->andReturn($this->generatePizzas(1))
            ->mock();

        $pizzas = $controller->getPizzas(new Request(), $pizzaRepository);

        verify($pizzas)->notNull();
        verify($pizzas->count())->equals(1);
    }

    public function testGetPizzasReturnsSomePizzas()
    {
        $controller = new MenuController();
        $pizzaRepository = m::mock('AwesomePizza\Menu\PizzaRepositoryContract')
            ->shouldReceive('take')
            ->with(MenuController::PIZZAS_PER_PAGE, 0)
            ->once()
            ->andReturn($this->generatePizzas(4))
            ->mock();

        $pizzas = $controller->getPizzas(new Request(), $pizzaRepository);

        verify($pizzas)->notNull();
        verify($pizzas->count())->equals(4);
    }

    public function testGetPizzasReturnsTonsOfPizzas()
    {
        $tonsOfPizzas = new Collection();

        $this->specify("take should be called", function() {
            $controller = new MenuController();
            $pizzaRepository = m::mock('AwesomePizza\Menu\PizzaRepositoryContract')
                ->shouldReceive('take')
                ->with(10, 0)
                ->once()
                ->andReturn($this->generatePizzas(10))
                ->mock();

            $pizzas = $controller->getPizzas(
                new Request(['quantity' => 10, 'offset' => 0]),
                $pizzaRepository
            );

            verify($pizzas)->notNull();
            verify($pizzas->count())->equals(10);
        });

        $this->specify("take should be called", function() {
            $controller = new MenuController();
            $pizzaRepository = m::mock('AwesomePizza\Menu\PizzaRepositoryContract')
                ->shouldReceive('take')
                ->with(7, 5)
                ->once()
                ->andReturn($this->generatePizzas(7))
                ->mock();

            $pizzas = $controller->getPizzas(
                new Request(['quantity' => 7, 'offset' => 5]),
                $pizzaRepository
            );

            verify($pizzas)->notNull();
            verify($pizzas->count())->equals(7);
        });
    }

    protected function generatePizzas($quantity)
    {
        $pizzas = new Collection();
        for ($i = 0; $i < $quantity; $i++) $pizzas->push(new Pizza());
        return $pizzas;
    }
}
