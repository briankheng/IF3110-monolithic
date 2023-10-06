<?php

class ProductAPI extends Controller {
    public function getProduct() {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            return json_response_fail(METHOD_NOT_ALLOWED);
        }

        $res = $this->model('Product')->getProduct($_GET['product_id']);
        if ($res) {
            json_response_success($res);
        } else {
            json_response_fail(PRODUCT_NOT_FOUND);
        }
    }

    public function showAllproducts($page = 1, $limit_page = 10) {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            return json_response_fail(METHOD_NOT_ALLOWED);
        }

        $res = $this->model('Product')->showAllproducts();
        $total = count($res);
        $res = array_slice($res, $page * $limit_page, $limit_page);

        // Pagination
        if ($res) {
            json_response_success(array("products" => $res, "pages" => ceil($total/$limit_page)));
        } else {
            json_response_fail(PRODUCT_NOT_FOUND);
        }
    }

    public function showAllcategories() {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            return json_response_fail(METHOD_NOT_ALLOWED);
        }

        $res = $this->model('Category')->showAllcategories();
        if ($res) {
            json_response_success($res);
        } else {
            json_response_fail(PRODUCT_NOT_FOUND);
        }
    }

    public function queryProduct($page = 1, $limit_page = 10) {
        // Blocking other method
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return json_response_fail(METHOD_NOT_ALLOWED);
        }

        $query = NULL;
        $order_by_price = NULL;
        $filter_category = NULL;
        $order_by_name = 'ASC';
        $filter_price = NULL;
        $page = (int) $page - 1;

        if (isset($_POST['order_by_price'])) {
            $order_by_price = $_POST['order_by_price'];
        }

        if (isset($_POST['filter_price'])) {
            if($_POST['filter_price'] != 'None') {
                $filter_price = $_POST['filter_price'];
            }
        }

        if (isset($_POST['filter_category'])) {
            if($_POST['filter_category'] != 'None') {
                $filter_category = $_POST['filter_category'];
            }
        }

        if (isset($_POST['query'])) {
            $query = $_POST['query'];
        }

        if (isset($_POST['order_by_name'])) {
            $order_by_name = $_POST['order_by_name'];
        }

        $res = $this->model('Product')->queryProduct($query, $order_by_price, $order_by_name, $filter_category, $filter_price);
        $total = count($res);
        $res = array_slice($res, $page * $limit_page, $limit_page);

        // Pagination
        if ($res) {
            json_response_success(array("products" => $res, "pages" => ceil($total/$limit_page)));
        } else {
            json_response_fail(PRODUCT_NOT_FOUND);
        }
    }

    public function buyProduct() {
        // Blocking other method
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return json_response_fail(METHOD_NOT_ALLOWED);
        }

        if (!isset($_SESSION['user_id'])) {
            return json_response_fail(NOT_LOGGED_IN);
        }

        $user_id = $_SESSION['user_id'];
        $product_id = $_POST['product_id'];
        $amount = $_POST['amount'];
        $total = $_POST['total'];

        try {
            // Mengurangi jumlah duit
            $res1 = $this->model('Users')->updateCash($user_id, $total * $amount);
            if (!$res1) {
                // If updating user's cash fails, rollback the transaction
                throw new Exception("Insufficient amount of money");
            }

            // Mengurangi stok produk
            $res2 = $this->model('Product')->updateStock($product_id, $amount);
            if (!$res2) {
                // If updating stock fails, rollback the transaction
                throw new Exception("Insufficient stock quantity, please enter a value below the stock limit");
            }

            // Nambah history beli
            $res3 = $this->model('History')->addHistoryBuy($user_id, $product_id, $amount, $total);
            if (!$res3) {
                // If adding purchase history fails, rollback the transaction
                throw new Exception("History update failed");
            }

            json_response_success("Item successfully purchased");

        } catch (Exception $e) {
            // Handle any exceptions that may occur during the transaction
            json_response_fail($e->getMessage());
        }
    }
}