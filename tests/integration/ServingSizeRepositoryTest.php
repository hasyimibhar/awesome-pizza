<?php

use AwesomePizza\Menu\ServingSizeRepository;

class ServingSizeRepositoryTest extends \Codeception\TestCase\Test
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

    public function testAllWithNoServingSize()
    {
        $this->specify("all should return no sizes", function() {
            $repository = new ServingSizeRepository($this->getDatabaseConnection());
            $sizes = $repository->all();

            verify($sizes)->notNull();
            verify($sizes->count())->equals(0);
        });
    }

    public function testAllWithOneServingSize()
    {
        $this->specify("all should return one size", function() {
            $now = date('Y-m-d H:i:s');
            $this->tester->haveInDatabase('serving_sizes', [
                'id' => 1,
                'name' => 'Tiny',
                'price' => 1234,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $repository = new ServingSizeRepository($this->getDatabaseConnection());
            $sizes = $repository->all();

            verify($sizes)->notNull();
            verify($sizes->count())->equals(1);

            $size = $sizes->first();
            verify($size->id)->equals(1);
            verify($size->name)->equals('Tiny');
            verify($size->price)->equals(1234);
            verify($size->created_at)->equals($now);
            verify($size->updated_at)->equals($now);
        });
    }

    public function testAllWithManyServingSizes()
    {
        $this->specify("all should return many sizes", function() {
            $now = date('Y-m-d H:i:s');

            $this->tester->haveInDatabase('serving_sizes', [
                'id' => 1,
                'name' => 'Tiny',
                'price' => 123,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $this->tester->haveInDatabase('serving_sizes', [
                'id' => 2,
                'name' => 'Small',
                'price' => 456,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $this->tester->haveInDatabase('serving_sizes', [
                'id' => 3,
                'name' => 'Medium',
                'price' => 789,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $repository = new ServingSizeRepository($this->getDatabaseConnection());
            $sizes = $repository->all();

            verify($sizes)->notNull();
            verify($sizes->count())->equals(3);

            $size1 = $sizes[0];
            verify($size1->id)->equals(1);
            verify($size1->name)->equals('Tiny');
            verify($size1->price)->equals(123);
            verify($size1->created_at)->equals($now);
            verify($size1->updated_at)->equals($now);

            $size2 = $sizes[1];
            verify($size2->id)->equals(2);
            verify($size2->name)->equals('Small');
            verify($size2->price)->equals(456);
            verify($size2->created_at)->equals($now);
            verify($size2->updated_at)->equals($now);

            $size3 = $sizes[2];
            verify($size3->id)->equals(3);
            verify($size3->name)->equals('Medium');
            verify($size3->price)->equals(789);
            verify($size3->created_at)->equals($now);
            verify($size3->updated_at)->equals($now);
        });
    }

    public function testFindWithValidId()
    {
        $this->specify("find should return one size", function() {
            $now = date('Y-m-d H:i:s');
            $this->tester->haveInDatabase('serving_sizes', [
                'id' => 99,
                'name' => 'Weird',
                'price' => 321,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $this->tester->haveInDatabase('serving_sizes', [
                'id' => 185,
                'name' => 'Humongous',
                'price' => 654,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $repository = new ServingSizeRepository($this->getDatabaseConnection());
            $size = $repository->find(99);

            verify($size)->notNull();
            verify($size->id)->equals(99);
            verify($size->name)->equals('Weird');
            verify($size->price)->equals(321);
            verify($size->created_at)->equals($now);
            verify($size->updated_at)->equals($now);

            $size = $repository->find(185);

            verify($size)->notNull();
            verify($size->id)->equals(185);
            verify($size->name)->equals('Humongous');
            verify($size->price)->equals(654);
            verify($size->created_at)->equals($now);
            verify($size->updated_at)->equals($now);
        });
    }

    public function testFindWithInvalidId()
    {
        $this->specify("find should return no size", function() {
            $now = date('Y-m-d H:i:s');
            $this->tester->haveInDatabase('serving_sizes', [
                'id' => 99,
                'name' => 'Weird',
                'price' => 321,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $this->tester->haveInDatabase('serving_sizes', [
                'id' => 185,
                'name' => 'Humongous',
                'price' => 654,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $repository = new ServingSizeRepository($this->getDatabaseConnection());

            $size = $repository->find(41);
            verify($size)->null();

            $size = $repository->find(77);
            verify($size)->null();
        });
    }

    public function testFindWithNoServingSize()
    {
        $this->specify("find should return no size", function() {
            $repository = new ServingSizeRepository($this->getDatabaseConnection());

            $size = $repository->find(1);
            verify($size)->null();

            $size = $repository->find(259);
            verify($size)->null();
        });
    }

    protected function getDatabaseConnection()
    {
        return $this->tester->grabService('Illuminate\Database\ConnectionInterface');
    }
}
