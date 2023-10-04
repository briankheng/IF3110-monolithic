<?php

class Users {
    private $table = 'users';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function showAllUsers() {
        $this->db->query('SELECT * FROM ' . $this-> table . ' ORDER BY id');

        try {
            return $this->db->resultSet();
        } catch (PDOException $e) {
            return  false;
        }
    }

    public function signup($data) {
        $this->db->query('INSERT INTO users (username, password, name, role) VALUES (:username, :password, :name, :role)');
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':role', $data['role']);

        return $this->db->execute();
    }

    public function getPassword($data) {
        $this->db->query('SELECT id, password FROM users WHERE username = :username');
        $this->db->bind(':username', $data);
    
        return $this->db->single();
    }
}