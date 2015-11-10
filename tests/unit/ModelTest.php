<?php

use AwesomePizza\Model;

class ModelTest extends \Codeception\TestCase\Test
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

    public function testConstructorWithNoAttributes()
    {
        $this->specify("model should have empty values", function() {
            $model = new Model();

            verify($model)->notNull();
            verify($model->id)->equals('');
            verify($model->created_at)->equals('');
            verify($model->updated_at)->equals('');
        });
    }

    public function testConstructorWithEmptyArray()
    {
        $this->specify("model should have empty values", function() {
            $model = new Model([]);

            verify($model)->notNull();
            verify($model->id)->equals('');
            verify($model->created_at)->equals('');
            verify($model->updated_at)->equals('');
        });
    }

    public function testConstructorWithAttributes()
    {
        $this->specify("model should have attributes", function() {
            $now = date('Y-m-d H:i:s');
            $model = new Model(['id' => 1, 'created_at' => $now, 'updated_at' => $now]);

            verify($model)->notNull();
            verify($model->id)->equals(1);
            verify($model->created_at)->equals($now);
            verify($model->updated_at)->equals($now);
        });
    }

    public function testToArray()
    {
        $this->specify("toArray should return array", function() {
            $now = date('Y-m-d H:i:s');
            $model = new Model(['id' => 123, 'created_at' => $now, 'updated_at' => $now]);

            $array = $model->toArray();
            verify($array)->notNull();
            verify(is_array($array))->true();
            verify($array['id'])->equals(123);
            verify($array['created_at'])->equals($now);
            verify($array['updated_at'])->equals($now);
        });
    }

    public function testToJson()
    {
        $this->specify("toJson should return json string", function() {
            $now = date('Y-m-d H:i:s');
            $model = new Model(['id' => 456, 'created_at' => $now, 'updated_at' => $now]);

            $json = $model->toJson();
            verify($json)->notNull();
            verify($json)->equals("{\"id\":456,\"created_at\":\"$now\",\"updated_at\":\"$now\"}");
        });
    }

    public function testJsonSerialize()
    {
        $this->specify("jsonSerialize should return array", function() {
            $now = date('Y-m-d H:i:s');
            $model = new Model(['id' => 777, 'created_at' => $now, 'updated_at' => $now]);

            $serialized = $model->toArray();
            verify($serialized)->notNull();
            verify(is_array($serialized))->true();
            verify($serialized['id'])->equals(777);
            verify($serialized['created_at'])->equals($now);
            verify($serialized['updated_at'])->equals($now);
        });
    }

    public function testToString()
    {
        $this->specify("__toString should return json string", function() {
            $now = date('Y-m-d H:i:s');
            $model = new Model(['id' => 6256, 'created_at' => $now, 'updated_at' => $now]);

            $string = $model->__toString();
            verify($string)->notNull();
            verify($string)->equals("{\"id\":6256,\"created_at\":\"$now\",\"updated_at\":\"$now\"}");
        });
    }
}
