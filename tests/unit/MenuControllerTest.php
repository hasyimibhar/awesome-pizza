<?php

use AwesomePizza\Http\Controllers\MenuController;
use AwesomePizza\Menu\PizzaRepositoryContract;
use \Mockery as m;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use AwesomePizza\Pizza;
use AwesomePizza\Crust;

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

    public function testGetPizzasOutsideOfRange()
    {
        $this->specify("when zero quantity is passed, the default quantity should be used", function() {
            $controller = new MenuController();
            $pizzaRepository = m::mock('AwesomePizza\Menu\PizzaRepositoryContract')
                ->shouldReceive('take')
                ->with(MenuController::PIZZAS_PER_PAGE, 0)
                ->once()
                ->andReturn($this->generatePizzas(5))
                ->mock();

            $pizzas = $controller->getPizzas(
                new Request(['quantity' => 0, 'offset' => 0]),
                $pizzaRepository
            );

            verify($pizzas)->notNull();
            verify($pizzas->count())->equals(5);
        });

        $this->specify("when negative quantity is passed, the default quantity should be used", function() {
            $controller = new MenuController();
            $pizzaRepository = m::mock('AwesomePizza\Menu\PizzaRepositoryContract')
                ->shouldReceive('take')
                ->with(MenuController::PIZZAS_PER_PAGE, 0)
                ->once()
                ->andReturn($this->generatePizzas(5))
                ->mock();

            $pizzas = $controller->getPizzas(
                new Request(['quantity' => -1, 'offset' => 0]),
                $pizzaRepository
            );

            verify($pizzas)->notNull();
            verify($pizzas->count())->equals(5);
        });

        $this->specify("when negative offset is passed, the default offset should be used", function() {
            $controller = new MenuController();
            $pizzaRepository = m::mock('AwesomePizza\Menu\PizzaRepositoryContract')
                ->shouldReceive('take')
                ->with(8, 0)
                ->once()
                ->andReturn($this->generatePizzas(5))
                ->mock();

            $pizzas = $controller->getPizzas(
                new Request(['quantity' => 8, 'offset' => -1]),
                $pizzaRepository
            );

            verify($pizzas)->notNull();
            verify($pizzas->count())->equals(5);
        });

        $this->specify("when negative offset is passed and zero quantity is passed, the default values should be used", function() {
            $controller = new MenuController();
            $pizzaRepository = m::mock('AwesomePizza\Menu\PizzaRepositoryContract')
                ->shouldReceive('take')
                ->with(MenuController::PIZZAS_PER_PAGE, 0)
                ->once()
                ->andReturn($this->generatePizzas(5))
                ->mock();

            $pizzas = $controller->getPizzas(
                new Request(['quantity' => 0, 'offset' => -1]),
                $pizzaRepository
            );

            verify($pizzas)->notNull();
            verify($pizzas->count())->equals(5);
        });

        $this->specify("when negative offset is passed and negative quantity is passed, the default values should be used", function() {
            $controller = new MenuController();
            $pizzaRepository = m::mock('AwesomePizza\Menu\PizzaRepositoryContract')
                ->shouldReceive('take')
                ->with(MenuController::PIZZAS_PER_PAGE, 0)
                ->once()
                ->andReturn($this->generatePizzas(5))
                ->mock();

            $pizzas = $controller->getPizzas(
                new Request(['quantity' => -6, 'offset' => -1]),
                $pizzaRepository
            );
            verify($pizzas)->notNull();
            verify($pizzas->count())->equals(5);
        });
    }

    public function testGetPizzasWithNonNumeric()
    {
        $this->specify("when string quantity is passed, the default value should be used", function() {
            $controller = new MenuController();
            $pizzaRepository = m::mock('AwesomePizza\Menu\PizzaRepositoryContract')
                ->shouldReceive('take')
                ->with(MenuController::PIZZAS_PER_PAGE, 3)
                ->once()
                ->andReturn($this->generatePizzas(MenuController::PIZZAS_PER_PAGE))
                ->mock();

            $pizzas = $controller->getPizzas(
                new Request(['quantity' => 'foobar', 'offset' => 3]),
                $pizzaRepository
            );

            verify($pizzas)->notNull();
            verify($pizzas->count())->equals(MenuController::PIZZAS_PER_PAGE);
        });

        $this->specify("when string offset is passed, the default value should be used", function() {
            $controller = new MenuController();
            $pizzaRepository = m::mock('AwesomePizza\Menu\PizzaRepositoryContract')
                ->shouldReceive('take')
                ->with(7, 0)
                ->once()
                ->andReturn($this->generatePizzas(7))
                ->mock();

            $pizzas = $controller->getPizzas(
                new Request(['quantity' => 7, 'offset' => 'hello, world!']),
                $pizzaRepository
            );

            verify($pizzas)->notNull();
            verify($pizzas->count())->equals(7);
        });

        $this->specify("when string quantity and offset are passed, the default values should be used", function() {
            $controller = new MenuController();
            $pizzaRepository = m::mock('AwesomePizza\Menu\PizzaRepositoryContract')
                ->shouldReceive('take')
                ->with(MenuController::PIZZAS_PER_PAGE, 0)
                ->once()
                ->andReturn($this->generatePizzas(MenuController::PIZZAS_PER_PAGE))
                ->mock();

            $pizzas = $controller->getPizzas(
                new Request(['quantity' => 'i am', 'offset' => 'awesome']),
                $pizzaRepository
            );

            verify($pizzas)->notNull();
            verify($pizzas->count())->equals(MenuController::PIZZAS_PER_PAGE);
        });
    }

    public function testGetCrustsReturnsNoCrust()
    {
        $this->specify("getCrusts should return empty collection", function() {
            $controller = new MenuController();
            $crustRepository = m::mock('AwesomePizza\Menu\CrustRepositoryContract')
                ->shouldReceive('all')
                ->once()
                ->andReturn(new Collection())
                ->mock();

            $crusts = $controller->getCrusts($crustRepository);

            verify($crusts)->notNull();
            verify($crusts->count())->equals(0);
        });
    }

    public function testGetCrustsReturnsOneCrust()
    {
        $this->specify("getCrusts should return one crust", function() {
            $controller = new MenuController();
            $crustRepository = m::mock('AwesomePizza\Menu\CrustRepositoryContract')
                ->shouldReceive('all')
                ->once()
                ->andReturn(new Collection([ new Crust() ]))
                ->mock();

            $crusts = $controller->getCrusts($crustRepository);

            verify($crusts)->notNull();
            verify($crusts->count())->equals(1);
        });
    }

    public function testGetCrustsReturnsSomeCrusts()
    {
        $this->specify("getCrusts should return empty collection", function() {
            $controller = new MenuController();
            $crustRepository = m::mock('AwesomePizza\Menu\CrustRepositoryContract')
                ->shouldReceive('all')
                ->once()
                ->andReturn(new Collection([ new Crust(), new Crust(), new Crust(), new Crust() ]))
                ->mock();

            $crusts = $controller->getCrusts($crustRepository);

            verify($crusts)->notNull();
            verify($crusts->count())->equals(4);
        });
    }

    protected function generatePizzas($quantity)
    {
        $pizzas = new Collection();
        for ($i = 0; $i < $quantity; $i++) $pizzas->push(new Pizza());
        return $pizzas;
    }
}
