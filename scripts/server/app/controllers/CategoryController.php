<?php

class CategoryController extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function getAllCategories() {
        $categories = $this->model('CategoryModel')->getAllCategories();

        return json_response_success($categories);
    }

    public function showAllcategories() {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            return json_response_fail(METHOD_NOT_ALLOWED);
        }

        $res = $this->model('CategoryModel')->getAllCategories();
        if ($res) {
            json_response_success($res);
        } else {
            json_response_fail(CATEGORY_NOT_FOUND);
        }
    }
}