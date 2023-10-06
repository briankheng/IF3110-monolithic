<?php

class History {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAllTopUpHistory($data) {
        $this->db->query('SELECT date, amount FROM topUp where idUser = :idUser');
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

    public function addHistoryBuy($user_id, $product_id, $amount, $total) {
        $this->db->query('INSERT INTO buyHistory (idUser, idProduct, quantity, totalPrice, buyDate) VALUES (:idUser, :idProduct, :quantity, :totalPrice, :buyDate)');
        $this->db->bind(':idUser', (int) $user_id);
        $this->db->bind(':idProduct', (int) $product_id);
        $this->db->bind(':quantity', (int) $amount);
        $this->db->bind(':totalprice', (int) $amount * $total);
        $this->db->bind(':buyDate', new DateTime());

        return $this->db->execute();
    }
}