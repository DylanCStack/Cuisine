<?php

    class Restaurant
    {
        private $name;
        private $address;
        private $website;
        private $phone;
        private $cuisine_id;
        private $user_id;
        private $id;

        function __construct($name, $address, $website, $phone, $cuisine_id, $user_id, $id=null){
            $this->name=$name;
            $this->address = $address;
            $this->website = $website;
            $this->phone = $phone;
            $this->cuisine_id = $cuisine_id;
            $this->user_id = $user_id;
            $this->id=$id;
        }

        function setName($name){
            $this->name = $name;
        }

        function getName(){
            return $this->name;
        }

        function setAddress($address){
            $this->address = $address;
        }

        function getAddress(){
            return $this->address;
        }

        function setWebsite($website){
            $this->website = $website;
        }

        function getWebsite(){
            return $this->website;
        }

        function setPhone($phone){
            $this->phone = $phone;
        }

        function getPhone(){
            return $this->phone;
        }

        function getCuisineId(){
            return $this->cuisine_id;
        }

        function getUserId(){
            return $this->user_id;
        }

        function getId(){
            return $this->id;
        }

        function save(){

            $all_restaurants = Restaurant::getAll();
            foreach ($all_restaurants as $restaurant) {
                if(strtolower($restaurant->getName()) == strtolower($this->name)){
                    return false;
                }
            }
            $GLOBALS['DB']->exec("INSERT INTO restaurant (name, address, website, phone, cuisine_id, user_id) VALUES ('{$this->getName()}', '{$this->address}', '{$this->website}', '{$this->phone}', {$this->cuisine_id}, {$this->user_id} )");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll(){
            $found_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurant;");
            $restaurants = array();
            foreach ($found_restaurants as $restaurant) {
                $restaurant_type = $restaurant['name'];
                $restaurant_address = $restaurant['address'];
                $restaurant_website = $restaurant['website'];
                $restaurant_phone = $restaurant['phone'];
                $restaurant_cuisine = $restaurant['cuisine_id'];
                $restaurant_user = $restaurant['user_id'];
                $restaurant_id = $restaurant['id'];
                $new_restaurant = new Restaurant($restaurant_type, $restaurant_address, $restaurant_website, $restaurant_phone, $restaurant_cuisine, $restaurant_user, $restaurant_id);
                array_push($restaurants, $new_restaurant);
            }
            return $restaurants;
        }

        static function getAllByCuisine($search_id){
            $found_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurant WHERE cuisine_id = {$search_id};");
            $restaurants = array();
            foreach ($found_restaurants as $restaurant) {
                $restaurant_type = $restaurant['name'];
                $restaurant_address = $restaurant['address'];
                $restaurant_website = $restaurant['website'];
                $restaurant_phone = $restaurant['phone'];
                $restaurant_cuisine = $restaurant['cuisine_id'];
                $restaurant_user = $restaurant['user_id'];
                $restaurant_id = $restaurant['id'];
                $new_restaurant = new Restaurant($restaurant_type, $restaurant_address, $restaurant_website, $restaurant_phone, $restaurant_cuisine, $restaurant_user, $restaurant_id);
                array_push($restaurants, $new_restaurant);
            }
            return $restaurants;
        }

        static function deleteAllByCuisine($search_id){
            $GLOBALS['DB']->exec("DELETE FROM restaurant WHERE cuisine_id = {$search_id};");
        }

        static function deleteAll(){
            $GLOBALS['DB']->exec("DELETE FROM restaurant;");
            $GLOBALS['DB']->exec("DELETE FROM review;");
        }

        static function find($search_id)
        {
            $found_restaurants = Restaurant::getAll();
            $returned_restaurant = null;

            foreach($found_restaurants as $restaurant)
            {
                $new_restaurant = $restaurant->getId();

                if($search_id == $new_restaurant){
                    $returned_restaurant = $restaurant;
                }

            }
            return $returned_restaurant;
        }

        static function findByName($search_name)
        {
            $found_restaurants = Restaurant::getAll();
            $returned_restaurant = null;

            foreach($found_restaurants as $restaurant)
            {
                $new_restaurant = $restaurant->getname();

                if($search_name == $new_restaurant){
                    $returned_restaurant = $restaurant;
                }

            }
            return $returned_restaurant;
        }


    }





?>
