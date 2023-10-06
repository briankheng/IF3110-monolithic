<?php

class UserModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllUsers() {
        $this->db->query('SELECT * FROM users ORDER BY id');

        return $this->db->resultSet();
    }

    public function getUserById($id) {
        $this->db->query('SELECT * FROM users WHERE id = :id');
        $this->db->bind(':id', $id);

        return $this->db->single();
    }

    public function getUserByUsername($username) {
        $this->db->query('SELECT * FROM users WHERE username = :username');
        $this->db->bind(':username', $username);

        return $this->db->single();
    }

    public function getUsersByPage($page) {
        $this->db->query('SELECT * FROM users ORDER BY id LIMIT :limit OFFSET :offset');
        $this->db->bind(':limit', (int) ROWS_PER_PAGE);
        $this->db->bind(':offset', ($page - 1) * ROWS_PER_PAGE);

        return $this->db->resultSet();
    }

    public function addUserBalance($id, $amount) {
        $this->db->query('UPDATE users SET balance = balance + :amount WHERE id = :id');
        $this->db->bind(':amount', $amount);
        $this->db->bind(':id', $id);

        return $this->db->execute();
    }
}