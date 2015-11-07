<?php

use AwesomePizza\Menu\PizzaPriceCalculator;
use AwesomePizza\Menu\Crust;
use AwesomePizza\Menu\ServingSize;
use AwesomePizza\Menu\Topping;
use Illuminate\Database\Eloquent\Collection;

class PizzaPriceCalculatorTest extends \Codeception\TestCase\Test
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

    public function testWithZeroPrice()
    {
        $this->specify("calculate should return 0", function() {
            $calculator = new PizzaPriceCalculator();

            $size = new ServingSize(['price' => 0]);
            $crust = new Crust(['price' => 0]);
            $toppings = new Collection([ new Topping(['price' => 0]) ]);

            $price = $calculator->calculate($size, $crust, $toppings);

            verify($price)->equals(0);
        });
    }

    public function testWithServingSize()
    {
        $this->specify("calculate should return serving size price", function() {
            $calculator = new PizzaPriceCalculator();

            $size = new ServingSize(['price' => 1234]);
            $crust = new Crust(['price' => 0]);
            $toppings = new Collection([ new Topping(['price' => 0]) ]);

            $price = $calculator->calculate($size, $crust, $toppings);

            verify($price)->equals(1234);
        });

        $this->specify("calculate should return serving size price", function() {
            $calculator = new PizzaPriceCalculator();

            $size = new ServingSize(['price' => 5012]);
            $crust = new Crust(['price' => 0]);
            $toppings = new Collection([ new Topping(['price' => 0]) ]);

            $price = $calculator->calculate($size, $crust, $toppings);

            verify($price)->equals(5012);
        });

        $this->specify("calculate should return serving size price", function() {
            $calculator = new PizzaPriceCalculator();

            $size = new ServingSize(['price' => 9999]);
            $crust = new Crust(['price' => 0]);
            $toppings = new Collection([ new Topping(['price' => 0]) ]);

            $price = $calculator->calculate($size, $crust, $toppings);

            verify($price)->equals(9999);
        });
    }

    public function testWithCrust()
    {
        $this->specify("calculate should return crust price", function() {
            $calculator = new PizzaPriceCalculator();

            $size = new ServingSize(['price' => 0]);
            $crust = new Crust(['price' => 9512]);
            $toppings = new Collection([ new Topping(['price' => 0]) ]);

            $price = $calculator->calculate($size, $crust, $toppings);

            verify($price)->equals(9512);
        });

        $this->specify("calculate should return crust price", function() {
            $calculator = new PizzaPriceCalculator();

            $size = new ServingSize(['price' => 0]);
            $crust = new Crust(['price' => 7155]);
            $toppings = new Collection([ new Topping(['price' => 0]) ]);

            $price = $calculator->calculate($size, $crust, $toppings);

            verify($price)->equals(7155);
        });

        $this->specify("calculate should return crust price", function() {
            $calculator = new PizzaPriceCalculator();

            $size = new ServingSize(['price' => 0]);
            $crust = new Crust(['price' => 9999]);
            $toppings = new Collection([ new Topping(['price' => 0]) ]);

            $price = $calculator->calculate($size, $crust, $toppings);

            verify($price)->equals(9999);
        });
    }

    public function testWithOneTopping()
    {
        $this->specify("calculate should return topping price", function() {
            $calculator = new PizzaPriceCalculator();

            $size = new ServingSize(['price' => 0]);
            $crust = new Crust(['price' => 0]);
            $toppings = new Collection([ new Topping(['price' => 6313]) ]);

            $price = $calculator->calculate($size, $crust, $toppings);

            verify($price)->equals(6313);
        });

        $this->specify("calculate should return topping price", function() {
            $calculator = new PizzaPriceCalculator();

            $size = new ServingSize(['price' => 0]);
            $crust = new Crust(['price' => 0]);
            $toppings = new Collection([ new Topping(['price' => 8163]) ]);

            $price = $calculator->calculate($size, $crust, $toppings);

            verify($price)->equals(8163);
        });

        $this->specify("calculate should return topping price", function() {
            $calculator = new PizzaPriceCalculator();

            $size = new ServingSize(['price' => 0]);
            $crust = new Crust(['price' => 0]);
            $toppings = new Collection([ new Topping(['price' => 9999]) ]);

            $price = $calculator->calculate($size, $crust, $toppings);

            verify($price)->equals(9999);
        });
    }

    public function testWithMultipleToppings()
    {
        $this->specify("calculate should return sum of topping price", function() {
            $calculator = new PizzaPriceCalculator();

            $size = new ServingSize(['price' => 0]);
            $crust = new Crust(['price' => 0]);
            $toppings = new Collection([ new Topping(['price' => 1234]), new Topping(['price' => 5678]) ]);

            $price = $calculator->calculate($size, $crust, $toppings);

            verify($price)->equals(6912);
        });

        $this->specify("calculate should return sum of topping price", function() {
            $calculator = new PizzaPriceCalculator();

            $size = new ServingSize(['price' => 0]);
            $crust = new Crust(['price' => 0]);
            $toppings = new Collection([
                new Topping(['price' => 9999]),
                new Topping(['price' => 5311]),
                new Topping(['price' => 7777]),
            ]);

            $price = $calculator->calculate($size, $crust, $toppings);

            verify($price)->equals(23087);
        });

        $this->specify("calculate should return sum of topping price", function() {
            $calculator = new PizzaPriceCalculator();

            $size = new ServingSize(['price' => 0]);
            $crust = new Crust(['price' => 0]);
            $toppings = new Collection([
                new Topping(['price' => 1234]),
                new Topping(['price' => 2345]),
                new Topping(['price' => 3456]),
                new Topping(['price' => 4567]),
            ]);

            $price = $calculator->calculate($size, $crust, $toppings);

            verify($price)->equals(11602);
        });
    }

    public function testWithSizeAndCrust()
    {
        $this->specify("calculate should return sum of serving size and crust price", function() {
            $calculator = new PizzaPriceCalculator();

            $size = new ServingSize(['price' => 1234]);
            $crust = new Crust(['price' => 5678]);
            $toppings = new Collection([ new Topping(['price' => 0]) ]);

            $price = $calculator->calculate($size, $crust, $toppings);

            verify($price)->equals(6912);
        });

        $this->specify("calculate should return sum of serving size and crust price", function() {
            $calculator = new PizzaPriceCalculator();

            $size = new ServingSize(['price' => 9999]);
            $crust = new Crust(['price' => 9999]);
            $toppings = new Collection([ new Topping(['price' => 0]) ]);

            $price = $calculator->calculate($size, $crust, $toppings);

            verify($price)->equals(19998);
        });

        $this->specify("calculate should return sum of serving size and crust price", function() {
            $calculator = new PizzaPriceCalculator();

            $size = new ServingSize(['price' => 5451]);
            $crust = new Crust(['price' => 9812]);
            $toppings = new Collection([ new Topping(['price' => 0]) ]);

            $price = $calculator->calculate($size, $crust, $toppings);

            verify($price)->equals(15263);
        });
    }

    public function testWithSizeAndTopping()
    {
        $this->specify("calculate should return sum of serving size and topping price", function() {
            $calculator = new PizzaPriceCalculator();

            $size = new ServingSize(['price' => 1234]);
            $crust = new Crust(['price' => 0]);
            $toppings = new Collection([ new Topping(['price' => 5678]) ]);

            $price = $calculator->calculate($size, $crust, $toppings);

            verify($price)->equals(6912);
        });

        $this->specify("calculate should return sum of serving size and topping price", function() {
            $calculator = new PizzaPriceCalculator();

            $size = new ServingSize(['price' => 9999]);
            $crust = new Crust(['price' => 0]);
            $toppings = new Collection([ new Topping(['price' => 9999]) ]);

            $price = $calculator->calculate($size, $crust, $toppings);

            verify($price)->equals(19998);
        });

        $this->specify("calculate should return sum of serving size and topping price", function() {
            $calculator = new PizzaPriceCalculator();

            $size = new ServingSize(['price' => 5451]);
            $crust = new Crust(['price' => 0]);
            $toppings = new Collection([ new Topping(['price' => 9999]) ]);

            $price = $calculator->calculate($size, $crust, $toppings);

            verify($price)->equals(15450);
        });
    }

    public function testWithCrustAndTopping()
    {
        $this->specify("calculate should return sum of crust and topping price", function() {
            $calculator = new PizzaPriceCalculator();

            $size = new ServingSize(['price' => 0]);
            $crust = new Crust(['price' => 1234]);
            $toppings = new Collection([ new Topping(['price' => 5678]) ]);

            $price = $calculator->calculate($size, $crust, $toppings);

            verify($price)->equals(6912);
        });

        $this->specify("calculate should return sum of crust and topping price", function() {
            $calculator = new PizzaPriceCalculator();

            $size = new ServingSize(['price' => 0]);
            $crust = new Crust(['price' => 1234]);
            $toppings = new Collection([ new Topping(['price' => 9999]) ]);

            $price = $calculator->calculate($size, $crust, $toppings);

            verify($price)->equals(11233);
        });

        $this->specify("calculate should return sum of crust and topping price", function() {
            $calculator = new PizzaPriceCalculator();

            $size = new ServingSize(['price' => 0]);
            $crust = new Crust(['price' => 7844]);
            $toppings = new Collection([ new Topping(['price' => 2333]) ]);

            $price = $calculator->calculate($size, $crust, $toppings);

            verify($price)->equals(10177);
        });
    }

    public function testWithAll()
    {
        $this->specify("calculate should return sum of serving size, crust, and topping price", function() {
            $calculator = new PizzaPriceCalculator();

            $size = new ServingSize(['price' => 7281]);
            $crust = new Crust(['price' => 9912]);
            $toppings = new Collection([ new Topping(['price' => 4511]) ]);

            $price = $calculator->calculate($size, $crust, $toppings);

            verify($price)->equals(21704);
        });

        $this->specify("calculate should return sum of serving size, crust, and topping price", function() {
            $calculator = new PizzaPriceCalculator();

            $size = new ServingSize(['price' => 1111]);
            $crust = new Crust(['price' => 2222]);
            $toppings = new Collection([ new Topping(['price' => 3333]) ]);

            $price = $calculator->calculate($size, $crust, $toppings);

            verify($price)->equals(6666);
        });

        $this->specify("calculate should return sum of serving size, crust, and topping price", function() {
            $calculator = new PizzaPriceCalculator();

            $size = new ServingSize(['price' => 9999]);
            $crust = new Crust(['price' => 8144]);
            $toppings = new Collection([ new Topping(['price' => 1245]) ]);

            $price = $calculator->calculate($size, $crust, $toppings);

            verify($price)->equals(19388);
        });
    }
}
