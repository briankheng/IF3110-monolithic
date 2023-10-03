<?php

class Category {
    private $table = 'category';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function showAllcategories() {
        $this->db->query('SELECT * FROM ' . $this-> table . ' ORDER BY id');

        try {
            return $this->db->resultSet();
        } catch (PDOException $e) {
            return  false;
        }
    }
}