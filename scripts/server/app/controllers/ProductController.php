<?php

class ProductController extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function getAllProducts() {
        $products = $this->model('ProductModel')->getAllProducts();

        json_response_success($products);
    }

    public function showAllproducts($page = 1, $limit_page = 10) {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            return json_response_fail(METHOD_NOT_ALLOWED);
        }

        $res = $this->model('ProductModel')->showAllproducts();
        $total = count($res);
        $res = array_slice($res, $page * $limit_page, $limit_page);

        // Pagination
        if ($res) {
            json_response_success(array("products" => $res, "pages" => ceil($total/$limit_page)));
        } else {
            json_response_fail(PRODUCT_NOT_FOUND);
        }
    }

    public function getProductById($id) {
        $product = $this->model('ProductModel')->getProductById($id);

        json_response_success($product);
    }

    public function getProduct() {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            return json_response_fail(METHOD_NOT_ALLOWED);
        }

        $res = $this->model('ProductModel')->getProduct($_GET['product_id']);
        if ($res) {
            json_response_success($res);
        } else {
            json_response_fail(PRODUCT_NOT_FOUND);
        }
    }

    public function getProductsByPage($page) {
        $products = $this->model('ProductModel')->getProductsByPage($page);

        json_response_success($products);
    }

    public function createProduct() {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return json_response_fail(INVALID_REQUEST_METHOD);
        }

        $data['name'] = $_POST['name'];
        $data['description'] = $_POST['description'];
        $data['price'] = $_POST['price'];
        $data['stock'] = $_POST['stock'];
        $data['idCategory'] = $_POST['idCategory'];
        $data['image'] = $_FILES['image']['name'];

        // Check if product name already exists
        if ($this->model('ProductModel')->getProductByName($data['name'])) {
            return json_response_fail("Product name already exists!");
        }
        
        // Move uploaded image and video to assets folder
        if ($data['image'] != '') {
            // Get image type
            $imageType = '';
            for ($i = strlen($data['image']) - 1; $i >= 0; $i--) {
                if ($data['image'][$i] == '.') {
                    $imageType = substr($data['image'], $i + 1);
                    break;
                }
            }

            if (strtolower($imageType) == 'mp4') {
                $videoPath = $_SERVER['DOCUMENT_ROOT'] . '/client/public/assets/videos/' . $data['image'];
                move_uploaded_file($_FILES['image']['tmp_name'], $videoPath);
            } else {
                $imagePath = $_SERVER['DOCUMENT_ROOT'] . '/client/public/assets/images/' . $data['image'];
                move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
            }
        } else {
            $data['image'] = 'default.jpg';
        }

        if ($this->model('ProductModel')->createProduct($data)) {
            return json_response_success("Product created successfully!");
        } else {
            return json_response_fail("Failed to create product!");
        }
    }

    public function editProduct($id) {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            json_response_fail(INVALID_REQUEST_METHOD);
        }

        $data['id'] = $id;
        $data['name'] = $_POST['name'];
        $data['image'] = $_FILES['image']['name'];
        $data['description'] = $_POST['description'];
        $data['idCategory'] = $_POST['idCategory'];
        $data['price'] = $_POST['price'];
        $data['stock'] = $_POST['stock'];

        // Move uploaded image and video to assets folder
        if ($data['image'] != '') {
            // Get image type
            $imageType = '';
            for ($i = strlen($data['image']) - 1; $i >= 0; $i--) {
                if ($data['image'][$i] == '.') {
                    $imageType = substr($data['image'], $i + 1);
                    break;
                }
            }

            if (strtolower($imageType) == 'mp4') {
                $videoPath = $_SERVER['DOCUMENT_ROOT'] . '/client/public/assets/videos/' . $data['image'];
                move_uploaded_file($_FILES['image']['tmp_name'], $videoPath);
            } else {
                $imagePath = $_SERVER['DOCUMENT_ROOT'] . '/client/public/assets/images/' . $data['image'];
                move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
            }
        } else {
            $data['image'] = $this->model('ProductModel')->getProductById($id)['image'];
        }

        if ($this->model('ProductModel')->editProduct($data)) {
            json_response_success("Product edited successfully!");
        } else {
            json_response_fail("Failed to edit product!");
        }
    }

    public function deleteProduct($id) {
        if ($_SERVER['REQUEST_METHOD'] != 'DELETE') {
            json_response_fail(INVALID_REQUEST_METHOD);
        }

        if ($this->model('ProductModel')->deleteProduct($id)) {
            json_response_success("Product deleted successfully!");
        } else {
            json_response_fail("Failed to delete product!");
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

        $res = $this->model('ProductModel')->queryProduct($query, $order_by_price, $order_by_name, $filter_category, $filter_price);
        $total = count($res);
        $res = array_slice($res, $page * $limit_page, $limit_page);

        // Pagination
        if ($res) {
            json_response_success(array("products" => $res, "pages" => ceil($total/$limit_page), "total" => $total));
        } else {
            json_response_fail(PRODUCT_NOT_FOUND);
        }
    }

    public function buyProduct() {
        // Blocking other method
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return json_response_fail(METHOD_NOT_ALLOWED);
        }

        $user_id = $_SESSION['user_id'];
        $product_id = $_POST['product_id'];
        $amount = $_POST['amount'];
        $total = $_POST['total'];

        try {
            // Mengurangi jumlah duit
            $res1 = $this->model('UserModel')->updateCash($user_id, $total * $amount);
            if (!$res1) {
                // If updating user's cash fails, rollback the transaction
                throw new Exception("Insufficient amount of money");
            }

            // Mengurangi stok produk
            $res2 = $this->model('ProductModel')->updateStock($product_id, $amount);
            if (!$res2) {
                // If updating stock fails, rollback the transaction
                throw new Exception("Insufficient stock quantity, please enter a value below the stock limit");
            }

            // Nambah history beli
            $res3 = $this->model('HistoryModel')->addHistoryBuy($user_id, $product_id, $amount, $total);
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
