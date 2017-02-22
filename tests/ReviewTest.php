<?php
    require_once 'src/Restaurant.php';
    require_once 'src/Cuisine.php';
    require_once 'src/Review.php';
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    $server = 'mysql:host=localhost:8889;dbname=cuisine_finder_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class ReviewTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Restaurant::deleteAll();
            Cuisine::deleteAll();
            Review::deleteAll();
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
            $restaurant->save();

            $review_text = "Test Test 1/5 poor service";
            $score = 1;
            $review_restaurant_id = $restaurant->getId();

            $review = new Review($review_text, $score, $review_restaurant_id);
            // Act
            $review->save();
            //Assert
            $result = Review::getAll();
            $this->assertEquals([$review], $result);
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

            $review1_text = "Test Test 1/5 poor service";
            $score1 = 1;
            $review1_restaurant_id = $restaurant1->getId();

            $review1 = new Review($review1_text, $score1, $review1_restaurant_id);
            $review1->save();


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

            $review2_text = "Test Test 2/5 poor service";
            $score2 = 2;
            $review2_restaurant_id = $restaurant2->getId();

            $review2 = new Review($review2_text, $score2, $review2_restaurant_id);
            $review2->save();

            //Assert
            $result = Review::getAllByRestaurant($restaurant1->getId());
            $this->assertEquals([$review1], $result);
        }

        function test_edit_review(){
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
            $restaurant->save();

            $review_text = "Test Test 1/5 poor service";
            $score = 1;
            $review_restaurant_id = $restaurant->getId();

            $review = new Review($review_text, $score, $review_restaurant_id);
            $review->save();

            $review_text_update = "NVM WE ALL GOOD";
            $score_update = 5;


            //Act
            $review->update($review_text_update, $score_update);

            //Assert
            $this->assertEquals("NVM WE ALL GOOD", $review->getReview());
        }

        function test_delete_review(){
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

            $review1_text = "Test Test 1/5 poor service";
            $score1 = 1;
            $review1_restaurant_id = $restaurant1->getId();

            $review1 = new Review($review1_text, $score1, $review1_restaurant_id);
            $review1->save();


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

            $review2_text = "Test Test 2/5 poor service";
            $score2 = 2;
            $review2_restaurant_id = $restaurant2->getId();

            $review2 = new Review($review2_text, $score2, $review2_restaurant_id);
            $review2->save();

            //Act
            $review1->delete();

            //Assert
            $this->assertEquals([$review2], Review::getAll());
        }
    }
?>
