<?php

use AwesomePizza\Menu\ToppingRepository;

class ToppingRepositoryTest extends \Codeception\TestCase\Test
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

    public function testAllWithNoTopping()
    {
        $this->specify("all should return no toppings", function() {
            $repository = new ToppingRepository($this->getDatabaseConnection());
            $toppings = $repository->all();

            verify($toppings)->notNull();
            verify($toppings->count())->equals(0);
        });
    }

    public function testAllWithOneTopping()
    {
        $this->specify("all should return one topping", function() {
            $now = date('Y-m-d H:i:s');
            $this->tester->haveInDatabase('toppings', [
                'id' => 11,
                'category' => 1,
                'name' => 'Meat Slice',
                'price' => 789,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $repository = new ToppingRepository($this->getDatabaseConnection());
            $toppings = $repository->all();

            verify($toppings)->notNull();
            verify($toppings->count())->equals(1);

            $topping = $toppings->first();
            verify($topping->id)->equals(11);
            verify($topping->category)->equals(1);
            verify($topping->name)->equals('Meat Slice');
            verify($topping->price)->equals(789);
            verify($topping->created_at)->equals($now);
            verify($topping->updated_at)->equals($now);
        });
    }

    public function testAllWithManyToppings()
    {
        $this->specify("all should return many toppings", function() {
            $now = date('Y-m-d H:i:s');

            $this->tester->haveInDatabase('toppings', [
                'id' => 11,
                'category' => 1,
                'name' => 'Meat Slice',
                'price' => 789,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $this->tester->haveInDatabase('toppings', [
                'id' => 12,
                'category' => 2,
                'name' => 'Prawn',
                'price' => 777,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $this->tester->haveInDatabase('toppings', [
                'id' => 13,
                'category' => 3,
                'name' => 'Spinach',
                'price' => 666,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $repository = new ToppingRepository($this->getDatabaseConnection());
            $toppings = $repository->all();

            verify($toppings)->notNull();
            verify($toppings->count())->equals(3);

            $topping1 = $toppings[0];
            verify($topping1->id)->equals(11);
            verify($topping1->category)->equals(1);
            verify($topping1->name)->equals('Meat Slice');
            verify($topping1->price)->equals(789);
            verify($topping1->created_at)->equals($now);
            verify($topping1->updated_at)->equals($now);

            $topping2 = $toppings[1];
            verify($topping2->id)->equals(12);
            verify($topping2->category)->equals(2);
            verify($topping2->name)->equals('Prawn');
            verify($topping2->price)->equals(777);
            verify($topping2->created_at)->equals($now);
            verify($topping2->updated_at)->equals($now);

            $topping3 = $toppings[2];
            verify($topping3->id)->equals(13);
            verify($topping3->category)->equals(3);
            verify($topping3->name)->equals('Spinach');
            verify($topping3->price)->equals(666);
            verify($topping3->created_at)->equals($now);
            verify($topping3->updated_at)->equals($now);
        });
    }

    public function testFindWithValidId()
    {
        $this->specify("find should return one topping", function() {
            $now = date('Y-m-d H:i:s');
            $this->tester->haveInDatabase('toppings', [
                'id' => 1,
                'category' => 1,
                'name' => 'Ground Beef',
                'price' => 456,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $this->tester->haveInDatabase('toppings', [
                'id' => 2,
                'category' => 3,
                'name' => 'Kailan',
                'price' => 333,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $repository = new ToppingRepository($this->getDatabaseConnection());
            $topping = $repository->find(1);

            verify($topping)->notNull();
            verify($topping->id)->equals(1);
            verify($topping->category)->equals(1);
            verify($topping->name)->equals('Ground Beef');
            verify($topping->price)->equals(456);
            verify($topping->created_at)->equals($now);
            verify($topping->updated_at)->equals($now);

            $topping = $repository->find(2);

            verify($topping)->notNull();
            verify($topping->id)->equals(2);
            verify($topping->category)->equals(3);
            verify($topping->name)->equals('Kailan');
            verify($topping->price)->equals(333);
            verify($topping->created_at)->equals($now);
            verify($topping->updated_at)->equals($now);
        });
    }

    public function testFindWithInvalidId()
    {
        $this->specify("find should return no topping", function() {
            $now = date('Y-m-d H:i:s');
            $this->tester->haveInDatabase('toppings', [
                'id' => 1,
                'category' => 1,
                'name' => 'Ground Beef',
                'price' => 456,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $this->tester->haveInDatabase('toppings', [
                'id' => 2,
                'category' => 3,
                'name' => 'Kailan',
                'price' => 333,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $repository = new ToppingRepository($this->getDatabaseConnection());

            $topping = $repository->find(9);
            verify($topping)->null();

            $topping = $repository->find(16);
            verify($topping)->null();
        });
    }

    public function testFindWithNoTopping()
    {
        $this->specify("find should return no topping", function() {
            $repository = new ToppingRepository($this->getDatabaseConnection());

            $topping = $repository->find(666);
            verify($topping)->null();

            $topping = $repository->find(123);
            verify($topping)->null();
        });
    }

    public function testFindManyWithEmptyArray()
    {
        $this->specify("findMany should return empty Collection", function() {
            $now = date('Y-m-d H:i:s');
            $this->tester->haveInDatabase('toppings', [
                'id' => 11,
                'category' => 1,
                'name' => 'Meat Slice',
                'price' => 789,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $this->tester->haveInDatabase('toppings', [
                'id' => 12,
                'category' => 2,
                'name' => 'Prawn',
                'price' => 777,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $this->tester->haveInDatabase('toppings', [
                'id' => 13,
                'category' => 3,
                'name' => 'Spinach',
                'price' => 666,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $repository = new ToppingRepository($this->getDatabaseConnection());
            $toppings = $repository->findMany([]);

            verify($toppings)->notNull();
            verify($toppings->count())->equals(0);
        });
    }

    public function testFindManyWithOneTopping()
    {
        $this->specify("findMany should return Collection with one item", function() {
            $now = date('Y-m-d H:i:s');
            $this->tester->haveInDatabase('toppings', [
                'id' => 11,
                'category' => 1,
                'name' => 'Meat Slice',
                'price' => 789,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $this->tester->haveInDatabase('toppings', [
                'id' => 12,
                'category' => 2,
                'name' => 'Prawn',
                'price' => 777,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $this->tester->haveInDatabase('toppings', [
                'id' => 13,
                'category' => 3,
                'name' => 'Spinach',
                'price' => 666,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $repository = new ToppingRepository($this->getDatabaseConnection());
            $toppings = $repository->findMany([13]);

            verify($toppings)->notNull();
            verify($toppings->count())->equals(1);

            $topping = $toppings[0];
            verify($topping->id)->equals(13);
            verify($topping->category)->equals(3);
            verify($topping->name)->equals('Spinach');
            verify($topping->price)->equals(666);
            verify($topping->created_at)->equals($now);
            verify($topping->updated_at)->equals($now);
        });
    }

    public function testFindManyWithManyToppings()
    {
        $this->specify("findMany should return Collection with many items", function() {
            $now = date('Y-m-d H:i:s');
            $this->tester->haveInDatabase('toppings', [
                'id' => 11,
                'category' => 1,
                'name' => 'Meat Slice',
                'price' => 789,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $this->tester->haveInDatabase('toppings', [
                'id' => 12,
                'category' => 2,
                'name' => 'Prawn',
                'price' => 777,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $this->tester->haveInDatabase('toppings', [
                'id' => 13,
                'category' => 3,
                'name' => 'Spinach',
                'price' => 666,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $repository = new ToppingRepository($this->getDatabaseConnection());
            $toppings = $repository->findMany([12, 13, 11]);

            verify($toppings)->notNull();
            verify($toppings->count())->equals(3);

            $topping1 = $toppings[0];
            verify($topping1->id)->equals(12);
            verify($topping1->category)->equals(2);
            verify($topping1->name)->equals('Prawn');
            verify($topping1->price)->equals(777);
            verify($topping1->created_at)->equals($now);
            verify($topping1->updated_at)->equals($now);

            $topping2 = $toppings[1];
            verify($topping2->id)->equals(13);
            verify($topping2->category)->equals(3);
            verify($topping2->name)->equals('Spinach');
            verify($topping2->price)->equals(666);
            verify($topping2->created_at)->equals($now);
            verify($topping2->updated_at)->equals($now);

            $topping3 = $toppings[2];
            verify($topping3->id)->equals(11);
            verify($topping3->category)->equals(1);
            verify($topping3->name)->equals('Meat Slice');
            verify($topping3->price)->equals(789);
            verify($topping3->created_at)->equals($now);
            verify($topping3->updated_at)->equals($now);
        });
    }

    public function testFindManyWithOneInvalidId()
    {
        $this->specify("findMany should return Collection with many items", function() {
            $now = date('Y-m-d H:i:s');
            $this->tester->haveInDatabase('toppings', [
                'id' => 11,
                'category' => 1,
                'name' => 'Meat Slice',
                'price' => 789,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $this->tester->haveInDatabase('toppings', [
                'id' => 12,
                'category' => 2,
                'name' => 'Prawn',
                'price' => 777,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $this->tester->haveInDatabase('toppings', [
                'id' => 13,
                'category' => 3,
                'name' => 'Spinach',
                'price' => 666,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $repository = new ToppingRepository($this->getDatabaseConnection());
            $toppings = $repository->findMany([12, 77, 11]);

            verify($toppings)->notNull();
            verify($toppings->count())->equals(2);

            $topping1 = $toppings[0];
            verify($topping1->id)->equals(12);
            verify($topping1->category)->equals(2);
            verify($topping1->name)->equals('Prawn');
            verify($topping1->price)->equals(777);
            verify($topping1->created_at)->equals($now);

            $topping2 = $toppings[1];
            verify($topping2->id)->equals(11);
            verify($topping2->category)->equals(1);
            verify($topping2->name)->equals('Meat Slice');
            verify($topping2->price)->equals(789);
            verify($topping2->created_at)->equals($now);
            verify($topping2->updated_at)->equals($now);
        });
    }

    public function testFindManyWithAllInvalidId()
    {
        $this->specify("findMany should return Collection with many items", function() {
            $now = date('Y-m-d H:i:s');
            $this->tester->haveInDatabase('toppings', [
                'id' => 11,
                'category' => 1,
                'name' => 'Meat Slice',
                'price' => 789,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $this->tester->haveInDatabase('toppings', [
                'id' => 12,
                'category' => 2,
                'name' => 'Prawn',
                'price' => 777,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $this->tester->haveInDatabase('toppings', [
                'id' => 13,
                'category' => 3,
                'name' => 'Spinach',
                'price' => 666,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $repository = new ToppingRepository($this->getDatabaseConnection());
            $toppings = $repository->findMany([7, 8, 9]);

            verify($toppings)->notNull();
            verify($toppings->count())->equals(0);
        });
    }

    protected function getDatabaseConnection()
    {
        return $this->tester->grabService('Illuminate\Database\ConnectionInterface');
    }
}
