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

            if ($imageType == 'jpg' || $imageType == 'png') {
                $imagePath = $_SERVER['DOCUMENT_ROOT'] . '/client/public/assets/images/' . $data['image'];
                move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
            } else {
                $videoPath = $_SERVER['DOCUMENT_ROOT'] . '/client/public/assets/videos/' . $data['image'];
                move_uploaded_file($_FILES['image']['tmp_name'], $videoPath);
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

            if ($imageType == 'jpg' || $imageType == 'png') {
                $imagePath = $_SERVER['DOCUMENT_ROOT'] . '/client/public/assets/images/' . $data['image'];
                move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
            } else {
                $videoPath = $_SERVER['DOCUMENT_ROOT'] . '/client/public/assets/videos/' . $data['image'];
                move_uploaded_file($_FILES['image']['tmp_name'], $videoPath);
            }
        } else {
            $data['image'] = 'default.jpg';
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
}
