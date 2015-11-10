<?php

use AwesomePizza\Ordering\OrderRepository;
use AwesomePizza\Ordering\Cart;

class OrderRepositoryTest extends \Codeception\TestCase\Test
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

        $now = date('Y-m-d H:i:s');
        $this->tester->haveInDatabase('users', [
            'id' => 1,
            'name' => 'Tester',
            'email' => 'tester@example.com',
            'password' => 'password',
            'remember_token' => 'abcde',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $this->tester->haveInDatabase('carts', [
            'id' => 1,
            'user_id' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $this->tester->haveInDatabase('carts', [
            'id' => 2,
            'user_id' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $this->tester->haveInDatabase('pizzas', [
            'id' => 1,
            'name' => 'Awesome Pizza',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $this->tester->haveInDatabase('pizzas', [
            'id' => 2,
            'name' => 'Epic Pizza',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $this->tester->haveInDatabase('crusts', [
            'id' => 2,
            'name' => 'Awesome Crust',
            'price' => 1000,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $this->tester->haveInDatabase('crusts', [
            'id' => 3,
            'name' => 'Epic Crust',
            'price' => 1000,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $this->tester->haveInDatabase('serving_sizes', [
            'id' => 3,
            'name' => 'Awesome Size',
            'price' => 1000,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $this->tester->haveInDatabase('serving_sizes', [
            'id' => 4,
            'name' => 'Epic Size',
            'price' => 1000,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    public function testFindWithValidId()
    {
        $this->specify("find should return one order", function() {
            $now = date('Y-m-d H:i:s');

            $this->tester->haveInDatabase('orders', [
                'id' => 42,
                'cart_id' => 1,
                'pizza_id' => 1,
                'crust_id' => 2,
                'size_id' => 3,
                'quantity' => 99,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $this->tester->haveInDatabase('orders', [
                'id' => 77,
                'cart_id' => 2,
                'pizza_id' => 1,
                'crust_id' => 2,
                'size_id' => 3,
                'quantity' => 66,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $repository = new OrderRepository($this->getDatabaseConnection());
            $order = $repository->find(new Cart(['id' => 1]), 42);

            verify($order)->notNull();
            verify($order->id)->equals(42);
            verify($order->cart_id)->equals(1);
            verify($order->pizza_id)->equals(1);
            verify($order->crust_id)->equals(2);
            verify($order->size_id)->equals(3);
            verify($order->quantity)->equals(99);
            verify($order->created_at)->equals($now);
            verify($order->updated_at)->equals($now);

            $order = $repository->find(new Cart(['id' => 2]), 77);

            verify($order)->notNull();
            verify($order->id)->equals(77);
            verify($order->cart_id)->equals(2);
            verify($order->pizza_id)->equals(1);
            verify($order->crust_id)->equals(2);
            verify($order->size_id)->equals(3);
            verify($order->quantity)->equals(66);
            verify($order->created_at)->equals($now);
            verify($order->updated_at)->equals($now);
        });
    }

    public function testFindWithInvalidId()
    {
        $this->specify("find should return no order", function() {
            $now = date('Y-m-d H:i:s');

            $this->tester->haveInDatabase('orders', [
                'id' => 42,
                'cart_id' => 1,
                'pizza_id' => 1,
                'crust_id' => 2,
                'size_id' => 3,
                'quantity' => 99,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $this->tester->haveInDatabase('orders', [
                'id' => 77,
                'cart_id' => 2,
                'pizza_id' => 1,
                'crust_id' => 2,
                'size_id' => 3,
                'quantity' => 66,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $repository = new OrderRepository($this->getDatabaseConnection());

            $order = $repository->find(new Cart(['id' => 1]), 33);
            verify($order)->null();

            $order = $repository->find(new Cart(['id' => 1]), 77);
            verify($order)->null();

            $order = $repository->find(new Cart(['id' => 2]), 39);
            verify($order)->null();

            $order = $repository->find(new Cart(['id' => 2]), 42);
            verify($order)->null();

            $order = $repository->find(new Cart(['id' => 3]), 42);
            verify($order)->null();

            $order = $repository->find(new Cart(['id' => 3]), 77);
            verify($order)->null();
        });
    }

    public function testFindWithNoOrder()
    {
        $this->specify("find should return no order", function() {
            $repository = new OrderRepository($this->getDatabaseConnection());

            $order = $repository->find(new Cart(['id' => 1]), 42);
            verify($order)->null();

            $order = $repository->find(new Cart(['id' => 2]), 77);
            verify($order)->null();
        });
    }

    public function testCreate()
    {
        $this->specify("create should insert the order in database", function() {
            $repository = new OrderRepository($this->getDatabaseConnection());

            $order = $repository->create(new Cart(['id' => 1]), [
                'pizza_id' => 1,
                'crust_id' => 2,
                'size_id' => 3,
                'quantity' => 123,
            ]);

            verify($order)->notNull();
            verify($order->cart_id)->equals(1);
            verify($order->pizza_id)->equals(1);
            verify($order->crust_id)->equals(2);
            verify($order->size_id)->equals(3);
            verify($order->quantity)->equals(123);

            $this->tester->seeInDatabase('orders', [
                'cart_id' => 1,
                'pizza_id' => 1,
                'crust_id' => 2,
                'size_id' => 3,
                'quantity' => 123,
            ]);
        });
    }

    public function testUpdate()
    {
        $this->specify("update should update the order in database", function() {
            $now = date('Y-m-d H:i:s');

            $this->tester->haveInDatabase('orders', [
                'id' => 555,
                'cart_id' => 1,
                'pizza_id' => 1,
                'crust_id' => 2,
                'size_id' => 3,
                'quantity' => 10,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $repository = new OrderRepository($this->getDatabaseConnection());

            $order = $repository->find(new Cart(['id' => 1]), 555);
            $repository->update($order, [
                'pizza_id' => 2,
                'crust_id' => 3,
                'size_id' => 4,
                'quantity' => 23,
                'updated_at' => '2020-10-10 00:00:00',
            ]);

            $this->tester->seeInDatabase('orders', [
                'id' => 555,
                'cart_id' => 1,
                'pizza_id' => 2,
                'crust_id' => 3,
                'size_id' => 4,
                'quantity' => 23,
                'created_at' => $now,
                'updated_at' => '2020-10-10 00:00:00',
            ]);
        });
    }

    public function testDelete()
    {
        $this->specify("delete should remove the order from database", function() {
            $now = date('Y-m-d H:i:s');

            $this->tester->haveInDatabase('orders', [
                'id' => 432,
                'cart_id' => 1,
                'pizza_id' => 1,
                'crust_id' => 2,
                'size_id' => 3,
                'quantity' => 99,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $repository = new OrderRepository($this->getDatabaseConnection());

            $order = $repository->find(new Cart(['id' => 1]), 432);
            $repository->delete($order);

            $this->tester->dontSeeInDatabase('orders', [
                'id' => 432,
                'cart_id' => 1,
                'pizza_id' => 1,
                'crust_id' => 2,
                'size_id' => 3,
                'quantity' => 99,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        });
    }

    protected function getDatabaseConnection()
    {
        return $this->tester->grabService('Illuminate\Database\ConnectionInterface');
    }
}
