<?php
    require_once 'src/Cuisine.php';
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    $server = 'mysql:host=localhost:8889;dbname=cuisine_finder_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CuisineTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Cuisine::deleteAll();
        }

        function test_save()
        {
            // Arrange
            $cuisine_type1 = 'Mexican';
            $id=null;
            $cuisine1 = new Cuisine($cuisine_type1, $id);

            $cuisine_type2 = 'Chinese';
            $id2=null;
            $cuisine2 = new Cuisine($cuisine_type2, $id2);
            // Act
            $cuisine1->save();
            $cuisine2->save();

            //Assert
            $result = Cuisine::getAll();
            $this->assertEquals([$cuisine1,$cuisine2], $result);
        }

        function test_find()
        {
            // Arrange
            $cuisine_type1 = 'Mexican';
            $id=null;
            $cuisine1 = new Cuisine($cuisine_type1, $id);

            $cuisine_type2 = 'Chinese';
            $id2=null;
            $cuisine2 = new Cuisine($cuisine_type2, $id2);
            // Act
            $cuisine1->save();
            $cuisine2->save();

            //Assert
            $result = Cuisine::find($cuisine1->getId());
            $this->assertEquals($cuisine1, $result);
        }
    }
?>
