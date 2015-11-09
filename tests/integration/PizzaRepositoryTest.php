<?php

use AwesomePizza\Menu\PizzaRepository;

class PizzaRepositoryTest extends \Codeception\TestCase\Test
{
    use Codeception\Specify;

    /**
     * @var \IntegrationTester
     */
    protected $tester;

    protected function _before()
    {
        $this->specifyConfig()->deepClone(false);

        // Run migrations
        $artisan = $this->tester->grabService('Illuminate\Contracts\Console\Kernel');
        $artisan->call('migrate', ['--database' => 'testing']);
    }

    public function testAllWithNoPizza()
    {
        $this->specify("all should return no pizzas", function() {
            $repository = new PizzaRepository($this->getDatabaseConnection());
            $pizzas = $repository->all();

            verify($pizzas)->notNull();
            verify($pizzas->count())->equals(0);
        });
    }

    public function testAllWithOnePizza()
    {
        $this->specify("all should return one pizza", function() {
            $now = date('Y-m-d H:i:s');
            $this->tester->haveInDatabase('pizzas', [
                'id' => 1,
                'name' => 'Awesome Pizza',
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $repository = new PizzaRepository($this->getDatabaseConnection());
            $pizzas = $repository->all();

            verify($pizzas)->notNull();
            verify($pizzas->count())->equals(1);

            $pizza = $pizzas->first();
            verify($pizza->id)->equals(1);
            verify($pizza->name)->equals('Awesome Pizza');
            verify($pizza->created_at)->equals($now);
            verify($pizza->updated_at)->equals($now);
        });
    }

    public function testAllWithManyPizzas()
    {
        $this->specify("all should return many pizzas", function() {
            $now = date('Y-m-d H:i:s');

            $this->tester->haveInDatabase('pizzas', [
                'id' => 1,
                'name' => 'Awesome Pizza',
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $this->tester->haveInDatabase('pizzas', [
                'id' => 2,
                'name' => 'Cool Pizza',
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $this->tester->haveInDatabase('pizzas', [
                'id' => 3,
                'name' => 'Epic Pizza',
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $repository = new PizzaRepository($this->getDatabaseConnection());
            $pizzas = $repository->all();

            verify($pizzas)->notNull();
            verify($pizzas->count())->equals(3);

            $pizza1 = $pizzas[0];
            verify($pizza1->id)->equals(1);
            verify($pizza1->name)->equals('Awesome Pizza');
            verify($pizza1->created_at)->equals($now);
            verify($pizza1->updated_at)->equals($now);

            $pizza2 = $pizzas[1];
            verify($pizza2->id)->equals(2);
            verify($pizza2->name)->equals('Cool Pizza');
            verify($pizza2->created_at)->equals($now);
            verify($pizza2->updated_at)->equals($now);

            $pizza3 = $pizzas[2];
            verify($pizza3->id)->equals(3);
            verify($pizza3->name)->equals('Epic Pizza');
            verify($pizza3->created_at)->equals($now);
            verify($pizza3->updated_at)->equals($now);
        });
    }

    public function testFindWithValidId()
    {
        $this->specify("find should return one pizza", function() {
            $now = date('Y-m-d H:i:s');
            $this->tester->haveInDatabase('pizzas', [
                'id' => 19,
                'name' => 'My Pizza',
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $this->tester->haveInDatabase('pizzas', [
                'id' => 42,
                'name' => 'Galaxy Pizza',
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $repository = new PizzaRepository($this->getDatabaseConnection());
            $pizza = $repository->find(19);

            verify($pizza)->notNull();
            verify($pizza->id)->equals(19);
            verify($pizza->name)->equals('My Pizza');
            verify($pizza->created_at)->equals($now);
            verify($pizza->updated_at)->equals($now);

            $pizza = $repository->find(42);

            verify($pizza)->notNull();
            verify($pizza->id)->equals(42);
            verify($pizza->name)->equals('Galaxy Pizza');
            verify($pizza->created_at)->equals($now);
            verify($pizza->updated_at)->equals($now);
        });
    }

    public function testFindWithInvalidId()
    {
        $this->specify("find should return one pizza", function() {
            $now = date('Y-m-d H:i:s');
            $this->tester->haveInDatabase('pizzas', [
                'id' => 19,
                'name' => 'My Pizza',
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $this->tester->haveInDatabase('pizzas', [
                'id' => 42,
                'name' => 'Galaxy Pizza',
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $repository = new PizzaRepository($this->getDatabaseConnection());

            $pizza = $repository->find(3);
            verify($pizza)->null();

            $pizza = $repository->find(25);
            verify($pizza)->null();
        });
    }

    public function testFindWithNoPizza()
    {
        $this->specify("find should return one pizza", function() {
            $repository = new PizzaRepository($this->getDatabaseConnection());

            $pizza = $repository->find(19);
            verify($pizza)->null();

            $pizza = $repository->find(42);
            verify($pizza)->null();
        });
    }

    protected function getDatabaseConnection()
    {
        return $this->tester->grabService('Illuminate\Database\ConnectionInterface');
    }
}
