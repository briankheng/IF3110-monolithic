<?php

class CategoryModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllCategories() {
        $this->db->query('SELECT * FROM category ORDER BY id');

        try {
            $this->db->execute();
            // Fetch and return results.
            return $this->db->resultSet();
        } catch (PDOException $e) {
            return  false;
        }
    }
}