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

    class CuisineTests extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Restaurant::deleteAll();
            Cuisine::deleteAll();
        }

        function test_getCuisineType()
        {
            $cuisine_type = "Wine";
            $id = null;
            $test_cuisine = new Cuisine($cuisine_type, $id);

            $output = $test_cuisine->getCuisineType();

            $this->assertEquals($cuisine_type, $output);
        }

        function test_getId()
        {
            $cuisine_type = "Wine";
            $id = 1;
            $test_cuisine = new Cuisine($cuisine_type, $id);

            $output = $test_cuisine->getId();

            $this->assertEquals(true, is_numeric($output));
        }

        function test_save()
        {
            $cuisine_type = "Wine";
            $id = null;
            $test_cuisine = new Cuisine($cuisine_type, $id);
            $test_cuisine->save();

            $output = Cuisine::getAll();

            $this->assertEquals($test_cuisine, $output[0]);
        }

        function test_getAll()
        {
            $id = null;
            $cuisine_type = "Wine";
            $cuisine_type2 = "Japanese";
            $test_cuisine = new Cuisine($cuisine_type, $id);
            $test_cuisine2 = new Cuisine($cuisine_type2, $id);
            $test_cuisine->save();
            $test_cuisine2->save();

            $output = Cuisine::getAll();

            $this->assertEquals([$test_cuisine, $test_cuisine2], $output);
        }

        function test_deleteAll()
        {
            $id = null;
            $cuisine_type = "Wine";
            $cuisine_type2 = "Japanese";
            $test_cuisine = new Cuisine($cuisine_type, $id);
            $test_cuisine2 = new Cuisine($cuisine_type2, $id);
            $test_cuisine->save();
            $test_cuisine2->save();

            Cuisine::deleteAll();
            $output = Cuisine::getAll();

            $this->assertEquals([], $output);

        }

        function test_find()
        {
            $id = null;
            $cuisine_type = "Wine";
            $cuisine_type2 = "Japanese";
            $test_cuisine = new Cuisine($cuisine_type, $id);
            $test_cuisine2 = new Cuisine($cuisine_type2, $id);
            $test_cuisine->save();
            $test_cuisine2->save();

            $output = Cuisine::find($test_cuisine->getId());

            $this->assertEquals($test_cuisine, $output);
        }

        function testGetRestaurants()
        {
            $cuisine_type = "Wine";
            $id = null;
            $test_cuisine = new Cuisine ($cuisine_type, $id);
            $test_cuisine->save();

            $test_cuisine_id = $test_cuisine->getId();

            $restaurant_name = "The Noble Rot";
            $test_restaurant = new Restaurant($restaurant_name, $id, $test_cuisine_id);
            $test_restaurant->save();

            $restaurant_name2 = "Paley's Place";
            $test_restaurant2 = new Restaurant($restaurant_name2, $id, $test_cuisine_id);
            $test_restaurant2->save();


            $output = $test_cuisine->getRestaurants();

            $this->assertEquals([$test_restaurant, $test_restaurant2], $output);
        }
    }
?>
