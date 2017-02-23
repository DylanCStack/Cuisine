<?php

    class Review
    {
        private $review;
        private $score;
        private $restaurant_id;
        private $id;

        function __construct($review, $score, $restaurant_id, $id=null){
            $this->review=$review;
            $this->score = $score;
            $this->restaurant_id = $restaurant_id;
            $this->id=$id;
        }

        function setReview($review){
            $this->review = $review;
        }

        function getReview(){
            return $this->review;
        }

        function setScore($score){
            $this->score = $score;
        }

        function getScore(){
            return $this->score;
        }

        function getRestaurantId(){
            return $this->restaurant_id;
        }

        function getId(){
            return $this->id;
        }

        function save(){
            $GLOBALS['DB']->exec("INSERT INTO review (review, score, restaurant_id) VALUES ('{$this->review}', {$this->score}, {$this->restaurant_id})");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function update($text_update, $score_update){
            $GLOBALS['DB']->exec("UPDATE review SET review = '{$text_update}', score = {$score_update} WHERE id = {$this->getId()};");
            $this->setReview($text_update);
            $this->setScore($score_update);
        }

        function delete(){
            $GLOBALS['DB']->exec("DELETE FROM review WHERE id = {$this->getId()};");
        }

        static function getAll(){
            $found_reviews = $GLOBALS['DB']->query("SELECT * FROM review;");
            $reviews = array();
            foreach ($found_reviews as $review) {
                $review_text = $review['review'];
                $review_score = $review['score'];
                $review_restaurant_id = $review['restaurant_id'];
                $review_id = $review['id'];
                $new_review = new Review($review_text, $review_score, $review_restaurant_id, $review_id);
                array_unshift($reviews, $new_review);
            }
            return $reviews;
        }

        static function getAllByRestaurant($search_id){
            $found_reviews = $GLOBALS['DB']->query("SELECT * FROM review WHERE restaurant_id = {$search_id};");
            $reviews = array();
            foreach ($found_reviews as $review) {
                $review_text = $review['review'];
                $review_score = $review['score'];
                $review_restaurant_id = $review['restaurant_id'];
                $review_id = $review['id'];
                $new_review = new Review($review_text, $review_score, $review_restaurant_id, $review_id);
                array_unshift($reviews, $new_review);
            }
            return $reviews;
        }

        static function deleteAll(){
            $GLOBALS['DB']->exec("DELETE FROM review;");
        }

        static function deleteAllByRestaurant($search_id){
            $GLOBALS['DB']->exec("DELETE FROM review WHERE restaurant_id = {$search_id};");
        }

        static function find($search_id)
        {
            $found_reviews = Review::getAll();
            $returned_review = null;

            foreach($found_reviews as $review)
            {
                $new_review = $review->getId();

                if($search_id == $new_review){
                    $returned_review = $review;
                }

            }
            return $returned_review;
        }

    }





?>
