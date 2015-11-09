<?php

use AwesomePizza\Menu\CrustRepository;

class CrustRepositoryTest extends \Codeception\TestCase\Test
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

    public function testAllWithNoCrust()
    {
        $this->specify("all should return no crusts", function() {
            $repository = new CrustRepository($this->getDatabaseConnection());
            $crusts = $repository->all();

            verify($crusts)->notNull();
            verify($crusts->count())->equals(0);
        });
    }

    public function testAllWithOneCrust()
    {
        $this->specify("all should return one crust", function() {
            $now = date('Y-m-d H:i:s');
            $this->tester->haveInDatabase('crusts', [
                'id' => 1,
                'name' => 'Thin Crust',
                'price' => 9999,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $repository = new CrustRepository($this->getDatabaseConnection());
            $crusts = $repository->all();

            verify($crusts)->notNull();
            verify($crusts->count())->equals(1);

            $crust = $crusts->first();
            verify($crust->id)->equals(1);
            verify($crust->name)->equals('Thin Crust');
            verify($crust->price)->equals(9999);
            verify($crust->created_at)->equals($now);
            verify($crust->updated_at)->equals($now);
        });
    }

    public function testAllWithManyCrusts()
    {
        $this->specify("all should return many crusts", function() {
            $now = date('Y-m-d H:i:s');

            $this->tester->haveInDatabase('crusts', [
                'id' => 1,
                'name' => 'Crust #1',
                'price' => 1234,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $this->tester->haveInDatabase('crusts', [
                'id' => 2,
                'name' => 'Crust #2',
                'price' => 5678,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $this->tester->haveInDatabase('crusts', [
                'id' => 3,
                'name' => 'Crust #3',
                'price' => 9999,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $repository = new CrustRepository($this->getDatabaseConnection());
            $crusts = $repository->all();

            verify($crusts)->notNull();
            verify($crusts->count())->equals(3);

            $crust1 = $crusts[0];
            verify($crust1->id)->equals(1);
            verify($crust1->name)->equals('Crust #1');
            verify($crust1->price)->equals(1234);
            verify($crust1->created_at)->equals($now);
            verify($crust1->updated_at)->equals($now);

            $crust2 = $crusts[1];
            verify($crust2->id)->equals(2);
            verify($crust2->name)->equals('Crust #2');
            verify($crust2->price)->equals(5678);
            verify($crust2->created_at)->equals($now);
            verify($crust2->updated_at)->equals($now);

            $crust3 = $crusts[2];
            verify($crust3->id)->equals(3);
            verify($crust3->name)->equals('Crust #3');
            verify($crust3->price)->equals(9999);
            verify($crust3->created_at)->equals($now);
            verify($crust3->updated_at)->equals($now);
        });
    }

    public function testFindWithValidId()
    {
        $this->specify("find should return one crust", function() {
            $now = date('Y-m-d H:i:s');
            $this->tester->haveInDatabase('crusts', [
                'id' => 11,
                'name' => 'Deluxe Crust',
                'price' => 4242,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $this->tester->haveInDatabase('crusts', [
                'id' => 37,
                'name' => 'Fuiyo Crust',
                'price' => 1111,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $repository = new CrustRepository($this->getDatabaseConnection());
            $crust = $repository->find(11);

            verify($crust)->notNull();
            verify($crust->id)->equals(11);
            verify($crust->name)->equals('Deluxe Crust');
            verify($crust->price)->equals(4242);
            verify($crust->created_at)->equals($now);
            verify($crust->updated_at)->equals($now);

            $crust = $repository->find(37);

            verify($crust)->notNull();
            verify($crust->id)->equals(37);
            verify($crust->name)->equals('Fuiyo Crust');
            verify($crust->price)->equals(1111);
            verify($crust->created_at)->equals($now);
            verify($crust->updated_at)->equals($now);
        });
    }

    public function testFindWithInvalidId()
    {
        $this->specify("find should return no crust", function() {
            $now = date('Y-m-d H:i:s');
            $this->tester->haveInDatabase('crusts', [
                'id' => 11,
                'name' => 'Delux Crust',
                'price' => 4242,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $this->tester->haveInDatabase('crusts', [
                'id' => 37,
                'name' => 'Fuiyo Crust',
                'price' => 1111,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $repository = new CrustRepository($this->getDatabaseConnection());

            $crust = $repository->find(3);
            verify($crust)->null();

            $crust = $repository->find(25);
            verify($crust)->null();
        });
    }

    public function testFindWithNoCrust()
    {
        $this->specify("find should return no crust", function() {
            $repository = new CrustRepository($this->getDatabaseConnection());

            $crust = $repository->find(19);
            verify($crust)->null();

            $crust = $repository->find(42);
            verify($crust)->null();
        });
    }

    protected function getDatabaseConnection()
    {
        return $this->tester->grabService('Illuminate\Database\ConnectionInterface');
    }
}
