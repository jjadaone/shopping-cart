<?php
class Order {
    public $db = null;

    public function __construct(Database $db) {
        if (!isset($db->con)) return null;
        $this->db = $db;
    }

    public function getOrders($user_id = null) {

        if ($user_id == null) {
            $result = $this->db->con->query("
                SELECT orders.order_id, orders.total_price, users.first_name, users.last_name, address, city, zipcode, order_status, order_date
                FROM orders
                INNER JOIN users
                ON users.user_id = orders.user_id
            ");
        } else {
            $result = $this->db->con->query("
                SELECT orders.order_id, orders.total_price, users.first_name, users.last_name, address, city, zipcode, order_status, order_date
                FROM orders
                INNER JOIN users
                ON users.user_id = orders.user_id
                WHERE users.user_id = $user_id
            ");
        }


        $resultArray = array();

        while ($order = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $resultArray[] = $order;
        }

        return $resultArray;
    }

    public function getSingleOrder($order_id) {
        $result = $this->db->con->query("
            SELECT * FROM orders 
            INNER JOIN users
            ON users.user_id = orders.user_id
            WHERE orders.order_id=$order_id
        ");

        $resultArray = array();

        while ($order = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $resultArray[] = $order;
        }

        return $resultArray;
    }

    public function addOrder($data) {
        
        $user_id = $data['user_id'];
        $address = $data['address'];
        $city = $data['city'];
        $zipcode = $data['zipcode'];
        $order_status = $data['order_status'];
        $order_date = $data['order_date'];
        // $updated_at = $data['updated_at'];

        // print_r($data);

        $result = $this->db->con->query("
            insert into 
            orders (user_id, address, city,  zipcode, order_status, order_date) 
            values ('$user_id', '$address', '$city', '$zipcode', '$order_status', '$order_date')
        ");

        if ($result) return true;
        else return false;
    }

    public function updateOrder($data) {

        $total = $data['total'];
        $order_id = $data['order_id'];
        
        $result = $this->db->con->query("
            UPDATE orders set total_price = $total WHERE order_id = $order_id
        ");

        if ($result) echo 'success update ';
        else echo 'fail update';

    }

    public function updateOrderStatus($data) {
        $order_id = $data['order_id'];
        $status = $data['status'];
        $delivery_date = $data['delivery_date'];
        $cancellation_date = $data['cancellation_date'];
        echo $order_id,$status,$delivery_date,$cancellation_date;

        $result = $this->db->con->query("
            UPDATE orders 
            SET order_status='$status', delivery_date='$delivery_date', cancellation_date='$cancellation_date'
            WHERE order_id=$order_id
        ");

        if ($result) echo 'success status change';
        else echo 'fail sttus change';
    }

    public function getTotalSales() {
        $result = $this->db->con->query("
            SELECT year(delivery_date), month(delivery_date) as mnth, sum(total_price) as total 
            FROM orders 
            WHERE order_status='delivered'
            GROUP BY month(delivery_date) 
        ");

        $resultArray = array();

        while ($order = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $resultArray[] = $order;
        }

        return $resultArray;
    }
    


}


?>

