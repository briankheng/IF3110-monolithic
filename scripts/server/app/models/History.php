<?php

class History {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAllTopUpHistory($data) {
        $this->db->query('SELECT topUpDate, amount FROM topUp where idUser = :idUser');
        $this->db->bind(':idUser', $data);

        try {
            return $this->db->resultSet();
        } catch (PDOException $e) {
            return  false;
        }
    }

    public function getAllBuyHistory($data) {
        $this->db->query('SELECT buyDate, totalPrice FROM buyHistory where idUser = :idUser');
        $this->db->bind(':idUser', $data);

        try {
            return $this->db->resultSet();
        } catch (PDOException $e) {
            return  false;
        }
    }
}