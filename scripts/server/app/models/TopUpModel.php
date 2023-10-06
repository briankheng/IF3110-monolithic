<?php

class TopUpModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllTopUps() {
        $this->db->query('SELECT
                            topUp.id AS top_up_id,
                            topUp.amount,
                            topUp.date,
                            topUp.status,
                            users.id AS user_id,
                            username
                        FROM topUp
                        INNER JOIN users ON topUp.idUser = users.id
                        ORDER BY topUp.status, topUp.date DESC, topUp.id DESC');

        return $this->db->resultSet();
    }

    public function getTopUpById($id) {
        $this->db->query('SELECT
                            topUp.id AS top_up_id,
                            topUp.amount,
                            topUp.date,
                            topUp.status,
                            users.id AS user_id,
                            username
                        FROM topUp
                        INNER JOIN users ON topUp.idUser = users.id
                        WHERE topUp.id = :id');
        $this->db->bind(':id', $id);

        return $this->db->single();
    }

    public function getTopUpsByPage($page) {
        $this->db->query('SELECT
                            topUp.id AS top_up_id,
                            topUp.amount,
                            topUp.date,
                            topUp.status,
                            users.id AS user_id,
                            username
                        FROM topUp
                        INNER JOIN users ON topUp.idUser = users.id
                        ORDER BY topUp.status, topUp.date DESC, topUp.id DESC
                        LIMIT :limit
                        OFFSET :offset');
        $this->db->bind(':limit', (int) ROWS_PER_PAGE);
        $this->db->bind(':offset', ($page - 1) * ROWS_PER_PAGE);

        return $this->db->resultSet();
    }

    public function createTopUp($data) {
        $this->db->query('INSERT INTO topUp (idUser, amount, date, status) VALUES (:idUser, :amount, :date, :status)');
        $this->db->bind(':idUser', $data['idUser']);
        $this->db->bind(':amount', $data['amount']);
        $this->db->bind(':date', $data['date']);
        $this->db->bind(':status', $data['status']);

        return $this->db->execute();
    }

    public function editTopUp($data) {
        $this->db->query('UPDATE topUp SET status = :status WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':status', $data['status']);

        return $this->db->execute();
    }

    public function deleteTopUp($id) {
        $this->db->query('DELETE FROM topUp WHERE id = :id');
        $this->db->bind(':id', $id);

        return $this->db->execute();
    }
}