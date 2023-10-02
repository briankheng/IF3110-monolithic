<?php

class ProductController extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function getAllProducts() {
        $products = $this->model('ProductModel')->getAllProducts();

        json_response_success($products);
    }

    public function getProductById($id) {
        $product = $this->model('ProductModel')->getProductById($id);

        json_response_success($product);
    }

    public function getProductsByCategory($idCategory) {
        $products = $this->model('ProductModel')->getProductsByCategory($idCategory);

        json_response_success($products);
    }

    public function searchProduct($keyword) {
        $products = $this->model('ProductModel')->searchProduct($keyword);

        json_response_success($products);
    }

    public function createProduct() {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            json_response_fail(INVALID_REQUEST_METHOD);
        }

        $data['name'] = $_POST['name'];
        $data['image'] = $_FILES['image']['name'];
        $data['video'] = $_FILES['video']['name'];
        $data['description'] = $_POST['description'];
        $data['idCategory'] = $_POST['idCategory'];
        $data['price'] = $_POST['price'];
        $data['stock'] = $_POST['stock'];

        // TODO: sanitize input
        
        if ($this->model('ProductModel')->createProduct($data)) {
            json_response_success("success");
        } else {
            json_response_fail("fail");
        }
    }

    public function editProduct($id) {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            json_response_fail(INVALID_REQUEST_METHOD);
        }

        $data['id'] = $id;
        $data['name'] = $_POST['name'];
        $data['image'] = $_FILES['image']['name'];
        $data['video'] = $_FILES['video']['name'];
        $data['description'] = $_POST['description'];
        $data['idCategory'] = $_POST['idCategory'];
        $data['price'] = $_POST['price'];
        $data['stock'] = $_POST['stock'];

        // TODO: sanitize input

        if ($this->model('ProductModel')->editProduct($data)) {
            json_response_success("success");
        } else {
            json_response_fail("fail");
        }
    }

    public function deleteProduct($id) {
        if ($_SERVER['REQUEST_METHOD'] != 'DELETE') {
            json_response_fail(INVALID_REQUEST_METHOD);
        }

        if ($this->model('ProductModel')->deleteProduct($id)) {
            json_response_success("success");
        } else {
            json_response_fail("fail");
        }
    }
}
