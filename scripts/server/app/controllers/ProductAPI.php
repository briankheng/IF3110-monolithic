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
}