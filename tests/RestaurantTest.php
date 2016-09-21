<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Restaurant.php";
    require_once "src/Cuisine.php";

    $server = 'mysql:host=localhost;dbname=restaurant_database_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class RestaurantTests extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Restaurant::deleteAll();
            Cuisine::deleteAll();
        }

        function test_getId()
        {
            $cuisine_type = "Wine";
            $id = null;
            $test_cuisine = new Cuisine($cuisine_type, $id);
            $test_cuisine->save();

            $restaurant_name = "Noble Rot";
            $cuisine_id = $test_cuisine->getId();
            $test_restaurant = new Restaurant($restaurant_name, $id, $cuisine_id);
            $test_restaurant->save();

            $output = $test_restaurant->getId();

            $this->assertEquals(true, is_numeric($output));
        }

        function test_getCuisineId()
        {
            $cuisine_type = "Wine";
            $id = null;
            $test_cuisine = new Cuisine($cuisine_type, $id);
            $test_cuisine->save();

            $restaurant_name = "Noble Rot";
            $cuisine_id = $test_cuisine->getId();
            $test_restaurant = new Restaurant($restaurant_name, $id, $cuisine_id);
            $test_restaurant->save();

            $output = $test_restaurant->getCuisineId();

            $this->assertEquals(true, is_numeric($output));
        }

        function test_save()
        {
            $cuisine_type = "Wine";
            $id = null;
            $test_cuisine = new Cuisine($cuisine_type, $id);
            $test_cuisine->save();

            $restaurant_name = "Noble Rot";
            $cuisine_id = $test_cuisine->getId();
            $test_restaurant = new Restaurant($restaurant_name, $id, $cuisine_id);

            $test_restaurant->save();

            $output = Restaurant::getAll();
            $this->assertEquals($test_restaurant, $output[0]);
        }

        function test_getAll()
        {
            $cuisine_type = "Wine";
            $id = null;
            $test_cuisine = new Cuisine($cuisine_type, $id);
            $test_cuisine->save();

            $restaurant_name = "Noble Rot";
            $cuisine_id = $test_cuisine->getId();
            $test_restaurant = new Restaurant($restaurant_name, $id, $cuisine_id);
            $test_restaurant->save();

            $restaurant_name2 = "Imperial";
            $test_restaurant2 = new Restaurant($restaurant_name2, $id, $cuisine_id);
            $test_restaurant2->save();

            $output = Restaurant::getAll();

            $this->assertEquals([$test_restaurant, $test_restaurant2], $output);
        }

        function test_deleteAll()
        {
            $cuisine_type = "Wine";
            $id = null;
            $test_cuisine = new Cuisine($cuisine_type, $id);
            $test_cuisine->save();

            $restaurant_name = "Noble Rot";
            $cuisine_id = $test_cuisine->getId();
            $test_restaurant = new Restaurant($restaurant_name, $id, $cuisine_id);
            $test_restaurant->save();

            $restaurant_name2 = "Imperial";
            $test_restaurant2 = new Restaurant($restaurant_name2, $id, $cuisine_id);
            $test_restaurant2->save();

            Restaurant::deleteAll();

            $output = Restaurant::getAll();
            $this->assertEquals([], $output);
        }

        function test_find()
        {
            $cuisine_type = "Wine";
            $id = null;
            $test_cuisine = new Cuisine($cuisine_type, $id);
            $test_cuisine->save();

            $restaurant_name = "Noble Rot";
            $cuisine_id = $test_cuisine->getId();
            $test_restaurant = new Restaurant($restaurant_name, $id, $cuisine_id);
            $test_restaurant->save();

            $restaurant_name2 = "Imperial";
            $test_restaurant2 = new Restaurant($restaurant_name2, $id, $cuisine_id);
            $test_restaurant2->save();

            $output = Restaurant::find($test_restaurant->getId());

            $this->assertEquals($test_restaurant, $output);
        }
    }
?>
