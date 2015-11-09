<?php

use AwesomePizza\Http\Controllers\MenuController;
use AwesomePizza\Menu\PizzaRepositoryContract;
use \Mockery as m;
use Illuminate\Support\Collection;
use Illuminate\Support\MessageBag;
use Illuminate\Http\Request;
use AwesomePizza\Menu\Pizza;
use AwesomePizza\Menu\Crust;
use AwesomePizza\Menu\ServingSize;
use AwesomePizza\Menu\Topping;
use AwesomePizza\Menu\PizzaDefaultTopping;

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
        $controller = new MenuController(m::mock('Illuminate\Contracts\Validation\Factory'));
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
        $controller = new MenuController(m::mock('Illuminate\Contracts\Validation\Factory'));
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
        $controller = new MenuController(m::mock('Illuminate\Contracts\Validation\Factory'));
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
            $controller = new MenuController(m::mock('Illuminate\Contracts\Validation\Factory'));
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
            $controller = new MenuController(m::mock('Illuminate\Contracts\Validation\Factory'));
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
            $controller = new MenuController(m::mock('Illuminate\Contracts\Validation\Factory'));
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
            $controller = new MenuController(m::mock('Illuminate\Contracts\Validation\Factory'));
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
            $controller = new MenuController(m::mock('Illuminate\Contracts\Validation\Factory'));
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
            $controller = new MenuController(m::mock('Illuminate\Contracts\Validation\Factory'));
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
            $controller = new MenuController(m::mock('Illuminate\Contracts\Validation\Factory'));
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
            $controller = new MenuController(m::mock('Illuminate\Contracts\Validation\Factory'));
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
            $controller = new MenuController(m::mock('Illuminate\Contracts\Validation\Factory'));
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
            $controller = new MenuController(m::mock('Illuminate\Contracts\Validation\Factory'));
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

    public function testGetPizzaReturnsOnePizza()
    {
        $this->specify("getPizza should return one pizza", function() {
            $controller = new MenuController(m::mock('Illuminate\Contracts\Validation\Factory'));
            $pizzaRepository = m::mock('AwesomePizza\Menu\PizzaRepositoryContract')
                ->shouldReceive('find')
                ->with(42)
                ->once()
                ->andReturn(new Pizza(['id' => 42]))
                ->mock();

            $pizza = $controller->getPizza($pizzaRepository, 42);

            verify($pizza)->notNull();
            verify($pizza->id)->equals(42);
        });
    }

    public function testGetPizzaReturnsNoPizza()
    {
        $this->specify("getPizzas should throw NotFoundHttpException", function() {
            $controller = new MenuController(m::mock('Illuminate\Contracts\Validation\Factory'));
            $pizzaRepository = m::mock('AwesomePizza\Menu\PizzaRepositoryContract')
                ->shouldReceive('find')
                ->with(456)
                ->once()
                ->andReturn(null)
                ->mock();

            $controller->getPizza($pizzaRepository, 456);
        }, ['throws' => 'Symfony\Component\HttpKernel\Exception\NotFoundHttpException']);
    }

    public function testGetPizzaWithNonNumeric()
    {
        $this->specify("getPizzas should throw NotFoundHttpException", function() {
            $controller = new MenuController(m::mock('Illuminate\Contracts\Validation\Factory'));
            $pizzaRepository = m::mock('AwesomePizza\Menu\PizzaRepositoryContract')
                ->shouldReceive('find')
                ->with('test')
                ->once()
                ->andReturn(null)
                ->mock();

            $controller->getPizza($pizzaRepository, 'test');
        }, ['throws' => 'Symfony\Component\HttpKernel\Exception\NotFoundHttpException']);
    }

    public function testGetCrustsReturnsNoCrust()
    {
        $this->specify("getCrusts should return empty collection", function() {
            $controller = new MenuController(m::mock('Illuminate\Contracts\Validation\Factory'));
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
            $controller = new MenuController(m::mock('Illuminate\Contracts\Validation\Factory'));
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
            $controller = new MenuController(m::mock('Illuminate\Contracts\Validation\Factory'));
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

    public function testGetCrustReturnsOneCrust()
    {
        $this->specify("getCrust should return one crust", function() {
            $controller = new MenuController(m::mock('Illuminate\Contracts\Validation\Factory'));
            $crustRepository = m::mock('AwesomePizza\Menu\CrustRepositoryContract')
                ->shouldReceive('find')
                ->with(123)
                ->once()
                ->andReturn(new Crust(['id' => 123]))
                ->mock();

            $crust = $controller->getCrust($crustRepository, 123);

            verify($crust)->notNull();
            verify($crust->id)->equals(123);
        });
    }

    public function testGetCrustReturnsNoCrust()
    {
        $this->specify("getCrust should throw NotFoundHttpException", function() {
            $controller = new MenuController(m::mock('Illuminate\Contracts\Validation\Factory'));
            $crustRepository = m::mock('AwesomePizza\Menu\CrustRepositoryContract')
                ->shouldReceive('find')
                ->with(456)
                ->once()
                ->andReturn(null)
                ->mock();

            $controller->getCrust($crustRepository, 456);
        }, ['throws' => 'Symfony\Component\HttpKernel\Exception\NotFoundHttpException']);
    }

    public function testGetCrustWithNonNumeric()
    {
        $this->specify("getCrust should throw NotFoundHttpException", function() {
            $controller = new MenuController(m::mock('Illuminate\Contracts\Validation\Factory'));
            $crustRepository = m::mock('AwesomePizza\Menu\CrustRepositoryContract')
                ->shouldReceive('find')
                ->with('test')
                ->once()
                ->andReturn(null)
                ->mock();

            $controller->getCrust($crustRepository, 'test');
        }, ['throws' => 'Symfony\Component\HttpKernel\Exception\NotFoundHttpException']);
    }

    public function testGetServingSizesReturnsNoSize()
    {
        $this->specify("getServingSizes should return empty collection", function() {
            $controller = new MenuController(m::mock('Illuminate\Contracts\Validation\Factory'));
            $sizeRepository = m::mock('AwesomePizza\Menu\ServingSizeRepositoryContract')
                ->shouldReceive('all')
                ->once()
                ->andReturn(new Collection())
                ->mock();

            $sizes = $controller->getServingSizes($sizeRepository);

            verify($sizes)->notNull();
            verify($sizes->count())->equals(0);
        });
    }

    public function testGetServingSizesReturnsOneSize()
    {
        $this->specify("getServingSizes should return one size", function() {
            $controller = new MenuController(m::mock('Illuminate\Contracts\Validation\Factory'));
            $sizeRepository = m::mock('AwesomePizza\Menu\ServingSizeRepositoryContract')
                ->shouldReceive('all')
                ->once()
                ->andReturn(new Collection([ new ServingSize() ]))
                ->mock();

            $sizes = $controller->getServingSizes($sizeRepository);

            verify($sizes)->notNull();
            verify($sizes->count())->equals(1);
        });
    }

    public function testGetServingSizesReturnsSomeSizes()
    {
        $this->specify("getServingSizes should return some sizes", function() {
            $controller = new MenuController(m::mock('Illuminate\Contracts\Validation\Factory'));
            $sizeRepository = m::mock('AwesomePizza\Menu\ServingSizeRepositoryContract')
                ->shouldReceive('all')
                ->once()
                ->andReturn(new Collection([ new ServingSize(), new ServingSize(), new ServingSize() ]))
                ->mock();

            $sizes = $controller->getServingSizes($sizeRepository);

            verify($sizes)->notNull();
            verify($sizes->count())->equals(3);
        });
    }

    public function testGetServingSizeReturnsOneSize()
    {
        $this->specify("getServingSize should return one crust", function() {
            $controller = new MenuController(m::mock('Illuminate\Contracts\Validation\Factory'));
            $servingSizeRepository = m::mock('AwesomePizza\Menu\ServingSizeRepositoryContract')
                ->shouldReceive('find')
                ->with(4582)
                ->once()
                ->andReturn(new ServingSize(['id' => 4582]))
                ->mock();

            $crust = $controller->getServingSize($servingSizeRepository, 4582);

            verify($crust)->notNull();
            verify($crust->id)->equals(4582);
        });
    }

    public function testGetServingSizeReturnsNoSize()
    {
        $this->specify("getServingSize should throw NotFoundHttpException", function() {
            $controller = new MenuController(m::mock('Illuminate\Contracts\Validation\Factory'));
            $servingSizeRepository = m::mock('AwesomePizza\Menu\ServingSizeRepositoryContract')
                ->shouldReceive('find')
                ->with(77)
                ->once()
                ->andReturn(null)
                ->mock();

            $controller->getServingSize($servingSizeRepository, 77);
        }, ['throws' => 'Symfony\Component\HttpKernel\Exception\NotFoundHttpException']);
    }

    public function testGetServingSizeWithNonNumeric()
    {
        $this->specify("getServingSize should throw NotFoundHttpException", function() {
            $controller = new MenuController(m::mock('Illuminate\Contracts\Validation\Factory'));
            $servingSizeRepository = m::mock('AwesomePizza\Menu\ServingSizeRepositoryContract')
                ->shouldReceive('find')
                ->with('nope')
                ->once()
                ->andReturn(null)
                ->mock();

            $controller->getServingSize($servingSizeRepository, 'nope');
        }, ['throws' => 'Symfony\Component\HttpKernel\Exception\NotFoundHttpException']);
    }

    public function testGetToppingsReturnsNoTopping()
    {
        $this->specify("getToppings should return empty collection", function() {
            $controller = new MenuController(m::mock('Illuminate\Contracts\Validation\Factory'));
            $toppingRepository = m::mock('AwesomePizza\Menu\ToppingRepositoryContract')
                ->shouldReceive('all')
                ->once()
                ->andReturn(new Collection())
                ->mock();

            $sizes = $controller->getToppings($toppingRepository);

            verify($sizes)->notNull();
            verify($sizes->count())->equals(0);
        });
    }

    public function testGetToppingsReturnsOneTopping()
    {
        $this->specify("getToppings should return one topping", function() {
            $controller = new MenuController(m::mock('Illuminate\Contracts\Validation\Factory'));
            $toppingRepository = m::mock('AwesomePizza\Menu\ToppingRepositoryContract')
                ->shouldReceive('all')
                ->once()
                ->andReturn(new Collection([ new Topping() ]))
                ->mock();

            $sizes = $controller->getToppings($toppingRepository);

            verify($sizes)->notNull();
            verify($sizes->count())->equals(1);
        });
    }

    public function testGetToppingsReturnsSomeToppings()
    {
        $this->specify("getToppings should return some toppings", function() {
            $controller = new MenuController(m::mock('Illuminate\Contracts\Validation\Factory'));
            $toppingRepository = m::mock('AwesomePizza\Menu\ToppingRepositoryContract')
                ->shouldReceive('all')
                ->once()
                ->andReturn(new Collection([ new Topping(), new Topping(), new Topping(), new Topping() ]))
                ->mock();

            $sizes = $controller->getToppings($toppingRepository);

            verify($sizes)->notNull();
            verify($sizes->count())->equals(4);
        });
    }

    public function testGetToppingReturnsOneTopping()
    {
        $this->specify("getTopping should return one crust", function() {
            $controller = new MenuController(m::mock('Illuminate\Contracts\Validation\Factory'));
            $toppingRepository = m::mock('AwesomePizza\Menu\ToppingRepositoryContract')
                ->shouldReceive('find')
                ->with(53)
                ->once()
                ->andReturn(new Topping(['id' => 53]))
                ->mock();

            $topping = $controller->getTopping($toppingRepository, 53);

            verify($topping)->notNull();
            verify($topping->id)->equals(53);
        });
    }

    public function testGetToppingReturnsNoTopping()
    {
        $this->specify("getTopping should throw NotFoundHttpException", function() {
            $controller = new MenuController(m::mock('Illuminate\Contracts\Validation\Factory'));
            $toppingRepository = m::mock('AwesomePizza\Menu\ToppingRepositoryContract')
                ->shouldReceive('find')
                ->with(91)
                ->once()
                ->andReturn(null)
                ->mock();

            $controller->getTopping($toppingRepository, 91);
        }, ['throws' => 'Symfony\Component\HttpKernel\Exception\NotFoundHttpException']);
    }

    public function testGetToppingWithNonNumeric()
    {
        $this->specify("getTopping should throw NotFoundHttpException", function() {
            $controller = new MenuController(m::mock('Illuminate\Contracts\Validation\Factory'));
            $toppingRepository = m::mock('AwesomePizza\Menu\ToppingRepositoryContract')
                ->shouldReceive('find')
                ->with('hello, world')
                ->once()
                ->andReturn(null)
                ->mock();

            $controller->getTopping($toppingRepository, 'hello, world');
        }, ['throws' => 'Symfony\Component\HttpKernel\Exception\NotFoundHttpException']);
    }

    public function testGetPizzaDetails()
    {
        $this->specify("getPizzaDetails should return price and toppings", function() {
            $validator = m::mock('Illuminate\Contracts\Validation\Validator')
                ->shouldReceive('fails')
                ->once()
                ->andReturn(false)
                ->mock();

            $validatorFactory = m::mock('Illuminate\Contracts\Validation\Factory')
                ->shouldReceive('make')
                ->with([
                    'crust_id' => 123,
                    'size_id' => 4582,
                ], [
                    'crust_id' => 'required|numeric',
                    'size_id' => 'required|numeric',
                ], [], [])
                ->once()
                ->andReturn($validator)
                ->mock();

            $controller = new MenuController($validatorFactory);

            $pizza = new Pizza(['id' => 123]);
            $pizzaRepository = m::mock('AwesomePizza\Menu\PizzaRepositoryContract')
                ->shouldReceive('find')
                ->with(123)
                ->once()
                ->andReturn($pizza)
                ->mock();

            $pizzaDefaultToppingRepository = m::mock('AwesomePizza\Menu\PizzaDefaultToppingRepositoryContract')
                ->shouldReceive('all')
                ->with($pizza)
                ->once()
                ->andReturn(new Collection([
                    new PizzaDefaultTopping(['pizza_id' => 123, 'topping_id' => 1]),
                    new PizzaDefaultTopping(['pizza_id' => 123, 'topping_id' => 2]),
                    new PizzaDefaultTopping(['pizza_id' => 123, 'topping_id' => 3]),
                ]))
                ->mock();

            $crust = new Crust(['id' => 123]);
            $crustRepository = m::mock('AwesomePizza\Menu\CrustRepositoryContract')
                ->shouldReceive('find')
                ->with(123)
                ->once()
                ->andReturn($crust)
                ->mock();

            $size = new ServingSize(['id' => 4582]);
            $servingSizeRepository = m::mock('AwesomePizza\Menu\ServingSizeRepositoryContract')
                ->shouldReceive('find')
                ->with(4582)
                ->once()
                ->andReturn($size)
                ->mock();

            $toppings = new Collection([
                new Topping(['id' => 1]),
                new Topping(['id' => 2]),
                new Topping(['id' => 3]),
            ]);
            $toppingRepository = m::mock('AwesomePizza\Menu\ToppingRepositoryContract')
                ->shouldReceive('findMany')
                ->with([1, 2, 3])
                ->once()
                ->andReturn($toppings)
                ->mock();

            $pizzaPriceCalculator = m::mock('AwesomePizza\Menu\PizzaPriceCalculatorContract')
                ->shouldReceive('calculate')
                ->with($size, $crust, $toppings)
                ->once()
                ->andReturn(12345)
                ->mock();

            $detail = $controller->getPizzaDetails(
                new Request(['crust_id' => 123, 'size_id' => 4582]),
                $pizzaDefaultToppingRepository,
                $pizzaRepository,
                $crustRepository,
                $servingSizeRepository,
                $toppingRepository,
                $pizzaPriceCalculator,
                123);

            verify($detail)->notNull();
            verify($detail['price'])->equals(12345);
        });
    }

    public function testGetPizzaDetailsWithInvalidPizza()
    {
        $this->specify("getPizzaDetails should throw NotFoundHttpException", function() {
            $validator = m::mock('Illuminate\Contracts\Validation\Validator')
                ->shouldReceive('fails')
                ->once()
                ->andReturn(false)
                ->mock();

            $validatorFactory = m::mock('Illuminate\Contracts\Validation\Factory')
                ->shouldReceive('make')
                ->with([
                    'crust_id' => 123,
                    'size_id' => 4582,
                ], [
                    'crust_id' => 'required|numeric',
                    'size_id' => 'required|numeric',
                ], [], [])
                ->once()
                ->andReturn($validator)
                ->mock();

            $controller = new MenuController($validatorFactory);

            $pizzaDefaultToppingRepository = m::mock('AwesomePizza\Menu\PizzaDefaultToppingRepositoryContract');

            $pizzaRepository = m::mock('AwesomePizza\Menu\PizzaRepositoryContract')
                ->shouldReceive('find')
                ->with(123)
                ->once()
                ->andReturn(null)
                ->mock();

            $crustRepository = m::mock('AwesomePizza\Menu\CrustRepositoryContract');
            $servingSizeRepository = m::mock('AwesomePizza\Menu\ServingSizeRepositoryContract');
            $toppingRepository = m::mock('AwesomePizza\Menu\ToppingRepositoryContract');
            $pizzaPriceCalculator = m::mock('AwesomePizza\Menu\PizzaPriceCalculatorContract');

            $controller->getPizzaDetails(
                new Request(['crust_id' => 123, 'size_id' => 4582]),
                $pizzaDefaultToppingRepository,
                $pizzaRepository,
                $crustRepository,
                $servingSizeRepository,
                $toppingRepository,
                $pizzaPriceCalculator,
                123);
        }, ['throws' => 'Symfony\Component\HttpKernel\Exception\NotFoundHttpException']);
    }

    public function testGetPizzaDetailsWithInvalidParameter()
    {
        $this->specify("getPizzaDetails should throw HttpResponseException", function() {
            $validator = m::mock('Illuminate\Contracts\Validation\Validator')
                ->shouldReceive('fails')
                ->once()
                ->andReturn(true)
                ->mock();
            $validator = $validator
                ->shouldReceive('getMessageBag')
                ->once()
                ->andReturn(new MessageBag())
                ->mock();

            $validatorFactory = m::mock('Illuminate\Contracts\Validation\Factory')
                ->shouldReceive('make')
                ->with([
                    'crust_id' => 123,
                    'size_id' => 4582,
                ], [
                    'crust_id' => 'required|numeric',
                    'size_id' => 'required|numeric',
                ], [], [])
                ->once()
                ->andReturn($validator)
                ->mock();

            $controller = new MenuController($validatorFactory);

            $pizzaDefaultToppingRepository = m::mock('AwesomePizza\Menu\PizzaDefaultToppingRepositoryContract');
            $pizzaRepository = m::mock('AwesomePizza\Menu\PizzaRepositoryContract');
            $crustRepository = m::mock('AwesomePizza\Menu\CrustRepositoryContract');
            $servingSizeRepository = m::mock('AwesomePizza\Menu\ServingSizeRepositoryContract');
            $toppingRepository = m::mock('AwesomePizza\Menu\ToppingRepositoryContract');
            $pizzaPriceCalculator = m::mock('AwesomePizza\Menu\PizzaPriceCalculatorContract');

            $controller->getPizzaDetails(
                new Request(['crust_id' => 123, 'size_id' => 4582]),
                $pizzaDefaultToppingRepository,
                $pizzaRepository,
                $crustRepository,
                $servingSizeRepository,
                $toppingRepository,
                $pizzaPriceCalculator,
                123);
        }, ['throws' => 'Illuminate\Http\Exception\HttpResponseException']);
    }

    public function testGetPizzaDetailsWithInvalidCrust()
    {
        $this->specify("getPizzaDetails should throw BadRequestHttpException", function() {
            $validator = m::mock('Illuminate\Contracts\Validation\Validator')
                ->shouldReceive('fails')
                ->once()
                ->andReturn(false)
                ->mock();

            $validatorFactory = m::mock('Illuminate\Contracts\Validation\Factory')
                ->shouldReceive('make')
                ->with([
                    'crust_id' => 123,
                    'size_id' => 4582,
                ], [
                    'crust_id' => 'required|numeric',
                    'size_id' => 'required|numeric',
                ], [], [])
                ->once()
                ->andReturn($validator)
                ->mock();

            $controller = new MenuController($validatorFactory);

            $pizzaDefaultToppingRepository = m::mock('AwesomePizza\Menu\PizzaDefaultToppingRepositoryContract')
                ->shouldReceive('all')
                ->with(123)
                ->once()
                ->andReturn(new Collection([
                    new PizzaDefaultTopping(['pizza_id' => 123, 'topping_id' => 1]),
                    new PizzaDefaultTopping(['pizza_id' => 123, 'topping_id' => 2]),
                    new PizzaDefaultTopping(['pizza_id' => 123, 'topping_id' => 3]),
                ]))
                ->mock();

            $pizzaRepository = m::mock('AwesomePizza\Menu\PizzaRepositoryContract')
                ->shouldReceive('find')
                ->with(123)
                ->once()
                ->andReturn(new Pizza(['id' => 123]))
                ->mock();

            $crustRepository = m::mock('AwesomePizza\Menu\CrustRepositoryContract')
                ->shouldReceive('find')
                ->with(123)
                ->once()
                ->andReturn(null)
                ->mock();

            $size = new ServingSize(['id' => 4582]);
            $servingSizeRepository = m::mock('AwesomePizza\Menu\ServingSizeRepositoryContract')
                ->shouldReceive('find')
                ->with(4582)
                ->once()
                ->andReturn($size)
                ->mock();

            $toppings = new Collection([
                new Topping(['id' => 1]),
                new Topping(['id' => 2]),
                new Topping(['id' => 3]),
            ]);
            $toppingRepository = m::mock('AwesomePizza\Menu\ToppingRepositoryContract')
                ->shouldReceive('findMany')
                ->with([1, 2, 3])
                ->once()
                ->andReturn($toppings)
                ->mock();

            $pizzaPriceCalculator = m::mock('AwesomePizza\Menu\PizzaPriceCalculatorContract');

            $controller->getPizzaDetails(
                new Request(['crust_id' => 123, 'size_id' => 4582]),
                $pizzaDefaultToppingRepository,
                $pizzaRepository,
                $crustRepository,
                $servingSizeRepository,
                $toppingRepository,
                $pizzaPriceCalculator,
                123);
        }, ['throws' => [
            'Symfony\Component\HttpKernel\Exception\BadRequestHttpException',
            'Invalid crust',
        ]]);
    }

    public function testGetPizzaDetailsWithInvalidSize()
    {
        $this->specify("getPizzaDetails should throw BadRequestHttpException", function() {
            $validator = m::mock('Illuminate\Contracts\Validation\Validator')
                ->shouldReceive('fails')
                ->once()
                ->andReturn(false)
                ->mock();

            $validatorFactory = m::mock('Illuminate\Contracts\Validation\Factory')
                ->shouldReceive('make')
                ->with([
                    'crust_id' => 123,
                    'size_id' => 4582,
                ], [
                    'crust_id' => 'required|numeric',
                    'size_id' => 'required|numeric',
                ], [], [])
                ->once()
                ->andReturn($validator)
                ->mock();

            $controller = new MenuController($validatorFactory);

            $pizzaDefaultToppingRepository = m::mock('AwesomePizza\Menu\PizzaDefaultToppingRepositoryContract')
                ->shouldReceive('all')
                ->with(123)
                ->once()
                ->andReturn(new Collection([
                    new PizzaDefaultTopping(['pizza_id' => 123, 'topping_id' => 1]),
                    new PizzaDefaultTopping(['pizza_id' => 123, 'topping_id' => 2]),
                    new PizzaDefaultTopping(['pizza_id' => 123, 'topping_id' => 3]),
                ]))
                ->mock();

            $pizzaRepository = m::mock('AwesomePizza\Menu\PizzaRepositoryContract')
                ->shouldReceive('find')
                ->with(123)
                ->once()
                ->andReturn(new Pizza(['id' => 123]))
                ->mock();

            $crust = new Crust(['id' => 123]);
            $crustRepository = m::mock('AwesomePizza\Menu\CrustRepositoryContract')
                ->shouldReceive('find')
                ->with(123)
                ->once()
                ->andReturn($crust)
                ->mock();

            $servingSizeRepository = m::mock('AwesomePizza\Menu\ServingSizeRepositoryContract')
                ->shouldReceive('find')
                ->with(4582)
                ->once()
                ->andReturn(null)
                ->mock();

            $toppings = new Collection([
                new Topping(['id' => 1]),
                new Topping(['id' => 2]),
                new Topping(['id' => 3]),
            ]);
            $toppingRepository = m::mock('AwesomePizza\Menu\ToppingRepositoryContract')
                ->shouldReceive('findMany')
                ->with([1, 2, 3])
                ->once()
                ->andReturn($toppings)
                ->mock();

            $pizzaPriceCalculator = m::mock('AwesomePizza\Menu\PizzaPriceCalculatorContract');

            $controller->getPizzaDetails(
                new Request(['crust_id' => 123, 'size_id' => 4582]),
                $pizzaDefaultToppingRepository,
                $pizzaRepository,
                $crustRepository,
                $servingSizeRepository,
                $toppingRepository,
                $pizzaPriceCalculator,
                123);
        }, ['throws' => [
            'Symfony\Component\HttpKernel\Exception\BadRequestHttpException',
            'Invalid serving size',
        ]]);
    }

    protected function generatePizzas($quantity)
    {
        $pizzas = new Collection();
        for ($i = 0; $i < $quantity; $i++) $pizzas->push(new Pizza());
        return $pizzas;
    }
}
