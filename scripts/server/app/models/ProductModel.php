<?php

class ProductModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllProducts() {
        $this->db->query('SELECT * FROM product');

        return $this->db->resultSet();
    }

    public function getProductById($id) {
        $this->db->query('SELECT * FROM product WHERE id = :id');
        $this->db->bind(':id', (int) $id);

        return $this->db->single();
    }

    public function getProductsByCategory($idCategory) {
        $this->db->query('SELECT * FROM product WHERE idCategory = :idCategory');
        $this->db->bind(':idCategory', (int) $idCategory);

        return $this->db->resultSet();
    }

    public function searchProduct($keyword) {
        $this->db->query('SELECT * FROM product WHERE name LIKE :keyword');
        $this->db->bind(':keyword', '%' . $keyword . '%');

        return $this->db->resultSet();
    }

    public function createProduct($data) {
        $this->db->query('INSERT INTO product (name, image, video, description, idCategory, price, stock) VALUES (:name, :image, :video, :description, :idCategory, :price, :stock)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':video', $data['video']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':idCategory', (int) $data['idCategory']);
        $this->db->bind(':price', (int) $data['price']);
        $this->db->bind(':stock', (int) $data['stock']);

        return $this->db->execute();
    }

    public function editProduct($data) {
        $this->db->query('UPDATE product SET name = :name, image = :image, video = :video, description = :description, idCategory = :idCategory, price = :price, stock = :stock WHERE id = :id');
        $this->db->bind(':id', (int) $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':video', $data['video']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':idCategory', (int) $data['idCategory']);
        $this->db->bind(':price', (int) $data['price']);
        $this->db->bind(':stock', (int) $data['stock']);

        return $this->db->execute();
    }

    public function deleteProduct($id) {
        $this->db->query('DELETE FROM product WHERE id = :id');
        $this->db->bind(':id', (int) $id);

        return $this->db->execute();
    }
}