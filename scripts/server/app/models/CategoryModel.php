<?php

class CategoryModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllCategories() {
        $this->db->query('SELECT * FROM category ORDER BY id');

        return $this->db->resultSet();
    }
}