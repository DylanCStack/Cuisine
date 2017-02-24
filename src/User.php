<?php

    class User
    {
        private $authority;
        private $name;
        private $password;
        private $id;

        function __construct($authority, $name, $password, $id=null){
            $this->authority=$authority;
            $this->name = $name;
            $this->password = $password;
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
        function setPassword($password){
            $this->password = $password;
        }

        function getPassword(){
            return $this->password;
        }


        function getId(){
            return $this->id;
        }

        function save(){
            $GLOBALS['DB']->exec("INSERT INTO user (authority, name, user_pw) VALUES ({$this->authority}, '{$this->name}', '{$this->password}')");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function delete(){
            $GLOBALS['DB']->exec("DELETE FROM user WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM review WHERE user_id = {$this->getId()};");
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

        static function login($username, $password)
        {
            $credentials = $GLOBALS['DB']->query("SELECT * FROM user;");
            if($credentials){
                foreach ($credentials as $user) {
                    if($user['name'] == $username && $user['user_pw'] == $password){
                        $new_user = new User ($user['authority'], $user['name'], $user['user_pw'], $user['id']);
                        $_SESSION['user'] = $new_user;

                    }
                }
            }
        }
        static function logout()
        {
            $_SESSION['user'] = array();
        }
        static function register($username, $password)
        {
            $credentials = $GLOBALS['DB']->query("SELECT * FROM user;");
            if($credentials !== false){
                foreach ($credentials as $user) {
                    if($user['name'] == $username){
                        return false;
                    }
                }
                $new_user = new User (0, $username, $password);
                $new_user->save();
                $_SESSION['user'] = $new_user;
            }
        }

    }
?>
