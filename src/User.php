<?php

    class User
    {
        private $authority;
        private $name;
        private $id;

        function __construct($authority, $name, $id=null){
            $this->authority=$authority;
            $this->name = $name;

            $this->id=$id;
        }

        function setAuthority($authority){
            $this->authority = $authority;
        }

        function getAuthority(){
            return $this->authority;
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
            $GLOBALS['DB']->exec("INSERT INTO user (authority, name) VALUES ('{$this->authority}', {$this->name})");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function delete(){
            $GLOBALS['DB']->exec("DELETE FROM user WHERE id = {$this->getId()};");
        }

        static function getAll(){
            $found_users = $GLOBALS['DB']->query("SELECT * FROM user;");
            $users = array();
            foreach ($found_users as $user) {
                $user_authority = $user['authority'];
                $user_name = $user['name'];
                $user_id = $user['id'];
                $new_user = new Review($user_authority, $user_name, $user_id);
                array_unshift($users, $new_user);
            }
            return $users;
        }

        static function deleteAll(){
            $GLOBALS['DB']->exec("DELETE FROM user;");
        }

        static function find($search_id)
        {
            $found_users = User::getAll();
            $returned_user = null;

            foreach($found_users as $user)
            {
                $new_user = $user->getId();

                if($search_id == $new_user){
                    $returned_user = $user;
                }

            }
            return $returned_user;
        }

    }
?>
