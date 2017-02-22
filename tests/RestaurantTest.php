<?php
    require_once 'src/Restaurant.php';
    require_once 'src/Cuisine.php';
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    $server = 'mysql:host=localhost:8889;dbname=cuisine_finder_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class RestaurantTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Restaurant::deleteAll();
            Cuisine::deleteAll();
        }

        function test_save()
        {
            // Arrange
            $cuisine_type1 = 'Mexican';
            $id=null;
            $cuisine1 = new Cuisine($cuisine_type1, $id);
            $cuisine1->save();

            $restaurant_name = "Taco Bills";
            $restaurant_address = "123 Four street. Portland, OR 97226";
            $restaurant_website = "TacoBills.ninja";
            $restaurant_phone = "123-456-7890";
            $restaurant_cuisine = $cuisine1->getId();

            $restaurant = new Restaurant($restaurant_name,$restaurant_address,$restaurant_website, $restaurant_phone, $restaurant_cuisine);
            // Act
            $restaurant->save();

            //Assert
            $result = Restaurant::getAll();
            $this->assertEquals([$restaurant], $result);
        }
        function test_get_by_cuisine()
        {
            // Arrange
            $cuisine_type1 = 'Mexican';
            $id=null;
            $cuisine1 = new Cuisine($cuisine_type1, $id);
            $cuisine1->save();

            $restaurant_name = "Taco Bills";
            $restaurant_address = "123 Four street. Portland, OR 97226";
            $restaurant_website = "TacoBills.ninja";
            $restaurant_phone = "123-456-7890";
            $restaurant_cuisine = $cuisine1->getId();

            $restaurant1 = new Restaurant($restaurant_name,$restaurant_address,$restaurant_website, $restaurant_phone, $restaurant_cuisine);
            $restaurant1->save();

            $cuisine_type2 = "Chinese";
            $id2 = null;
            $cuisine2 = new Cuisine($cuisine_type2,$id);
            $cuisine2->save();

            $restaurant2_name = "Bamboo Express";
            $restaurant2_address = "123 Four street. Portland, OR 97226";
            $restaurant2_website = "BambooExpress.ninja";
            $restaurant2_phone = "123-456-7890";
            $restaurant2_cuisine = $cuisine2->getId();
            $restaurant2 = new Restaurant($restaurant2_name,$restaurant2_address,$restaurant2_website, $restaurant2_phone, $restaurant2_cuisine);
            $restaurant2->save();

            //Assert
            $result = Restaurant::getAllByCuisine($cuisine1->getId());
            $this->assertEquals([$restaurant1], $result);
        }
    }
?>
