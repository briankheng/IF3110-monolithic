<?php

class ProductModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllProducts() {
        $this->db->query('SELECT 
                            product.id AS product_id,
                            product.name AS product_name,
                            product.image,
                            product.description,
                            category.name AS category_name,
                            product.price,
                            product.stock
                        FROM product
                        INNER JOIN category ON product.idCategory = category.id
                        ORDER BY product.name');

        return $this->db->resultSet();
    }

    public function getProductById($id) {
        $this->db->query('SELECT 
                            product.id AS product_id,
                            product.name AS product_name,
                            product.image,
                            product.description,
                            category.name AS category_name,
                            product.price,
                            product.stock
                        FROM product
                        INNER JOIN category ON product.idCategory = category.id
                        WHERE product.id = :id
                        ORDER BY product.name');
        $this->db->bind(':id', (int) $id);

        return $this->db->single();
    }

    public function getProductsByCategory($idCategory) {
        $this->db->query('SELECT * FROM product WHERE idCategory = :idCategory');
        $this->db->bind(':idCategory', (int) $idCategory);

        return $this->db->resultSet();
    }

    public function getProductsByPage($page) {
        $this->db->query('SELECT 
                            product.id AS product_id,
                            product.name AS product_name,
                            product.image,
                            product.description,
                            category.name AS category_name,
                            product.price,
                            product.stock
                        FROM product
                        INNER JOIN category ON product.idCategory = category.id
                        ORDER BY product.name
                        LIMIT :limit
                        OFFSET :offset');
        $this->db->bind(':offset', (int) ($page - 1) * ROWS_PER_PAGE);
        $this->db->bind(':limit', (int) ROWS_PER_PAGE);

        return $this->db->resultSet();
    }

    public function getProductByName($name) {
        $this->db->query('SELECT * FROM product WHERE name = :name');
        $this->db->bind(':name', $name);

        return $this->db->single();
    }

    public function searchProduct($keyword) {
        $this->db->query('SELECT * FROM product WHERE name LIKE :keyword');
        $this->db->bind(':keyword', '%' . $keyword . '%');

        return $this->db->resultSet();
    }

    public function createProduct($data) {
        $this->db->query('INSERT INTO product (name, image, description, idCategory, price, stock) VALUES (:name, :image, :description, :idCategory, :price, :stock)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':idCategory', (int) $data['idCategory']);
        $this->db->bind(':price', (int) $data['price']);
        $this->db->bind(':stock', (int) $data['stock']);

        return $this->db->execute();
    }

    public function editProduct($data) {
        $this->db->query('UPDATE product SET name = :name, image = :image, description = :description, idCategory = :idCategory, price = :price, stock = :stock WHERE id = :id');
        $this->db->bind(':id', (int) $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':image', $data['image']);
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