<?php

    class Cuisine
    {
        private $name;
        private $id;

        function __construct($name, $id=null){
            $this->name=$name;
            $this->id=$id;
        }

        function setName($name){
            $this->name = $name;
        }

        function getName(){
            return $this->name;
        }

        function getId(){
            return $this->id;
        }

        function save(){
            $all_cuisines = Cuisine::getAll();
            foreach ($all_cuisines as $cuisine) {
                if(strtolower($cuisine->getName()) == strtolower($this->name)){
                    return false;
                }
            }
            $GLOBALS['DB']->exec("INSERT INTO cuisine (name) VALUES ('{$this->getName()}')");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll(){
            $found_cuisines = $GLOBALS['DB']->query("SELECT * FROM cuisine;");
            $cuisines = array();
            foreach ($found_cuisines as $cuisine) {
                $cuisine_type = $cuisine['name'];
                $cuisine_id = $cuisine['id'];
                $new_cuisine = new Cuisine($cuisine_type, $cuisine_id);
                array_push($cuisines, $new_cuisine);
            }
            return $cuisines;
        }

        function delete(){
            $restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurant WHERE cuisine_id = {$this->id};");
            foreach($restaurants as $restaurant){
                $GLOBALS['DB']->exec("DELETE FROM review WHERE restaurant_id = {$restaurant['id']};");
            }
            $GLOBALS['DB']->exec("DELETE FROM restaurant WHERE cuisine_id = {$this->id};");
            $GLOBALS['DB']->exec("DELETE FROM cuisine WHERE id = {$this->id};");
        }

        function update($name){
            $GLOBALS['DB']->exec("UPDATE cuisine SET name = '{$name}' WHERE id = {$this->getId()};");
            $this->setName($name);
        }

        static function deleteAll(){
            $GLOBALS['DB']->exec("DELETE FROM cuisine;");
            $GLOBALS['DB']->exec("DELETE FROM restaurant;");
            $GLOBALS['DB']->exec("DELETE FROM review;");
        }

        static function find($search_id)
        {
            $found_cuisines = Cuisine::getAll();
            $returned_cuisine = null;

            foreach($found_cuisines as $cuisine)
            {
                $new_cuisine = $cuisine->getId();

                if($search_id == $new_cuisine){
                    $returned_cuisine = $cuisine;
                }

            }
            return $returned_cuisine;
        }

        static function findByName($search_name)
        {
            $found_cuisines = Cuisine::getAll();
            $returned_cuisine = null;

            foreach($found_cuisines as $cuisine)
            {
                $new_cuisine = $cuisine->getname();

                if($search_name == $new_cuisine){
                    $returned_cuisine = $cuisine;
                }

            }
            return $returned_cuisine;
        }

    }





?>
