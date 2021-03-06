<?php
class Review {
    public $db = null;

    public function __construct(Database $db) {
        if (!isset($db->con)) return null;
        $this->db = $db;
    }

    public function getReviews($product_id) {

        $result = $this->db->con->query("
            SELECT * FROM reviews 
            INNER JOIN users
            ON reviews.user_id = users.user_id 
            WHERE reviews.product_id = $product_id
        ");

        $resultArray = array();

        while ($review = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $resultArray[] = $review;
        }

        return $resultArray;
    }

    public function getSingleReview($product_id, $user_id) {
        $result = $this->db->con->query("
            SELECT * FROM reviews WHERE product_id = $product_id AND user_id = $user_id
        ");

        $resultArray = array();

        while ($review = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $resultArray[] = $review;
        }

        return $resultArray;

    }

    public function addReview($data) {
        $product_id = $this->db->con->real_escape_string($data['product_id']);
        $user_id = $this->db->con->real_escape_string($data['user_id']);
        $rating = $this->db->con->real_escape_string($data['rating']);
        $review = $this->db->con->real_escape_string($data['review']);
        $date_created = $this->db->con->real_escape_string($data['date_created']);

        $result = $this->db->con->query("
            INSERT INTO reviews (product_id, user_id, rating, review, date_created) VALUES('$product_id', '$user_id', '$rating', '$review', '$date_created')
        ");

        if ($result) echo 'success';
        else echo 'fail review';

    }

    public function updateReview($data) {
        $product_id = $this->db->con->real_escape_string($data['product_id']);
        $user_id = $this->db->con->real_escape_string($data['user_id']);
        $rating = $this->db->con->real_escape_string($data['rating']);
        $review = $this->db->con->real_escape_string($data['review']);
        $date_created = $this->db->con->real_escape_string($data['date_created']);

        $result = $this->db->con->query("
            UPDATE reviews
            SET rating = '$rating', review = '$review', date_created = '$date_created'
            WHERE user_id = $user_id AND product_id = $product_id
        ");

        if ($result) echo 'success';
        else echo 'fail review';
    }

    public function isReviewExists($product_id, $user_id) {
        $result = $this->db->con->query("
            SELECT * FROM reviews WHERE product_id = $product_id AND user_id = $user_id
        ");

        if (mysqli_num_rows($result) == 1) return true;
        else return false;
    }

}


?>

