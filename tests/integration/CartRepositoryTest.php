<?php

use AwesomePizza\Ordering\CartRepository;
use AwesomePizza\User;

class CartRepositoryTest extends \Codeception\TestCase\Test
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

        $this->tester->haveInDatabase('users', [
            'id' => 2,
            'name' => 'Another Tester',
            'email' => 'anothertester@example.com',
            'password' => 'password',
            'remember_token' => 'abcde',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    public function testFindWithValidId()
    {
        $this->specify("find should return one cart", function() {
            $now = date('Y-m-d H:i:s');

            $this->tester->haveInDatabase('carts', [
                'id' => 23,
                'user_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $this->tester->haveInDatabase('carts', [
                'id' => 76,
                'user_id' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $repository = new CartRepository($this->getDatabaseConnection());
            $cart = $repository->find(new User(['id' => 1]), 23);

            verify($cart)->notNull();
            verify($cart->id)->equals(23);
            verify($cart->user_id)->equals(1);
            verify($cart->created_at)->equals($now);
            verify($cart->updated_at)->equals($now);

            $cart = $repository->find(new User(['id' => 2]), 76);

            verify($cart)->notNull();
            verify($cart->id)->equals(76);
            verify($cart->user_id)->equals(2);
            verify($cart->created_at)->equals($now);
            verify($cart->updated_at)->equals($now);
        });
    }

    public function testFindWithInvalidId()
    {
        $this->specify("find should return no cart", function() {
            $now = date('Y-m-d H:i:s');

            $this->tester->haveInDatabase('carts', [
                'id' => 23,
                'user_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $this->tester->haveInDatabase('carts', [
                'id' => 76,
                'user_id' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $repository = new CartRepository($this->getDatabaseConnection());

            $cart = $repository->find(new User(['id' => 1]), 42);
            verify($cart)->null();

            $cart = $repository->find(new User(['id' => 1]), 76);
            verify($cart)->null();

            $cart = $repository->find(new User(['id' => 2]), 11);
            verify($cart)->null();

            $cart = $repository->find(new User(['id' => 2]), 23);
            verify($cart)->null();

            $cart = $repository->find(new User(['id' => 3]), 23);
            verify($cart)->null();

            $cart = $repository->find(new User(['id' => 3]), 76);
            verify($cart)->null();
        });
    }

    public function testFindWithNoCart()
    {
        $this->specify("find should return no cart", function() {
            $repository = new CartRepository($this->getDatabaseConnection());

            $cart = $repository->find(new User(['id' => 1]), 23);
            verify($cart)->null();

            $cart = $repository->find(new User(['id' => 2]), 76);
            verify($cart)->null();
        });
    }

    public function testCreate()
    {
        $this->specify("create should insert the cart in database", function() {
            $repository = new CartRepository($this->getDatabaseConnection());

            $cart = $repository->create(new User(['id' => 1]));

            verify($cart)->notNull();
            verify($cart->user_id)->equals(1);

            $this->tester->seeInDatabase('carts', [
                'user_id' => 1,
            ]);
        });
    }

    public function testUpdate()
    {
        $this->specify("update should update the cart in database", function() {
            $now = date('Y-m-d H:i:s');

            $this->tester->haveInDatabase('carts', [
                'id' => 456,
                'user_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $repository = new CartRepository($this->getDatabaseConnection());

            $cart = $repository->find(new User(['id' => 1]), 456);
            $repository->update($cart, [
                'updated_at' => '2020-10-10 00:00:00',
            ]);

            $this->tester->seeInDatabase('carts', [
                'id' => 456,
                'user_id' => 1,
                'created_at' => $now,
                'updated_at' => '2020-10-10 00:00:00',
            ]);
        });
    }

    public function testDelete()
    {
        $this->specify("delete should remove the cart from database", function() {
            $now = date('Y-m-d H:i:s');

            $this->tester->haveInDatabase('carts', [
                'id' => 123,
                'user_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $repository = new CartRepository($this->getDatabaseConnection());

            $cart = $repository->find(new User(['id' => 1]), 123);
            $repository->delete($cart);

            $this->tester->dontSeeInDatabase('carts', [
                'id' => 123,
                'user_id' => 1,
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
