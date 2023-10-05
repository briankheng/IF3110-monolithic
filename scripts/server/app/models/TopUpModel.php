<?php

class TopUpModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllTopUps() {
        $this->db->query('SELECT * FROM top_up ORDER BY id');

        return $this->db->resultSet();
    }

    public function getTopUpById($id) {
        $this->db->query('SELECT * FROM top_up WHERE id = :id');
        $this->db->bind(':id', $id);

        return $this->db->single();
    }

    public function getTopUpsByPage($page) {
        $this->db->query('SELECT * FROM top_up ORDER BY id LIMIT :limit OFFSET :offset');
        $this->db->bind(':limit', (int) ROWS_PER_PAGE);
        $this->db->bind(':offset', ($page - 1) * ROWS_PER_PAGE);

        return $this->db->resultSet();
    }

    public function createTopUp($data) {
        
    }

    public function editTopUp($data) {
        
    }

    public function deleteTopUp($id) {
        
    }
}