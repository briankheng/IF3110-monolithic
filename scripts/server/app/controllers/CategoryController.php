<?php

class CategoryController extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function getAllCategories() {
        $categories = $this->model('CategoryModel')->getAllCategories();

        return json_response_success($categories);
    }
}