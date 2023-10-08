<?php

class ProductModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function showAllproducts() {
        // SQL query with explicit JOIN and ordering by name.
        $sql = 'SELECT 
                product.id AS product_id,
                product.name AS product_name,
                product.image,
                product.description,
                category.name AS category_name,
                price,
                stock
            FROM product
            INNER JOIN category ON product.idCategory = category.id WHERE stock > 0';

        try {
            // Prepare and execute the query.
            $this->db->query($sql);
            $this->db->execute();

            // Fetch and return results.
            return $this->db->resultSet();
        } catch (PDOException $e) {
            return  false;
        }
    }

    public function getAllProducts() {
        $this->db->query('SELECT 
                            product.id AS product_id,
                            product.name AS product_name,
                            product.image,
                            product.description,
                            category.name AS category_name,
                            category.id AS category_id,
                            product.price,
                            product.stock
                        FROM product
                        INNER JOIN category ON product.idCategory = category.id 
                        ORDER BY product.name');

        return $this->db->resultSet();
    }

    public function getProduct($id) {
        $this->db->query('SELECT 
                            product.id AS product_id,
                            product.name AS product_name,
                            product.image,
                            product.description,
                            category.name AS category_name,
                            price,
                            stock
                        FROM product
                        INNER JOIN category ON product.idCategory = category.id 
                        WHERE product.id = :id
                        ORDER BY product.name');
        $this->db->bind(':id', (int) $id);

        try {
            $this->db->execute();
            return $this->db->single();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getProductById($id) {
        $this->db->query('SELECT 
                            product.id AS product_id,
                            product.name AS product_name,
                            product.image,
                            product.description,
                            category.name AS category_name,
                            category.id AS category_id,
                            product.price,
                            product.stock
                        FROM product
                        INNER JOIN category ON product.idCategory = category.id 
                        WHERE product.id = :id
                        ORDER BY product.name');
        $this->db->bind(':id', (int) $id);

        return $this->db->single();
    }

    public function getProductsByPage($page) {
        $this->db->query('SELECT 
                            product.id AS product_id,
                            product.name AS product_name,
                            product.image,
                            product.description,
                            category.name AS category_name,
                            category.id AS category_id,
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

    public function queryProduct($query, $orderByPrice, $orderByName, $filterByCategory, $filterByPrice) {
        $likeQuery = '%' . $query . '%';
        $filterCategory = '%' . $filterByCategory . '%';
        $pricequery = NULL;
        if ($filterByPrice == '< 5K') {
            $pricequery = 'price < 5000';
        } else if ($filterByPrice == '5K - 30K') {
            $pricequery = 'price BETWEEN 5000 AND 30000';
        } else if ($filterByPrice == '30K - 100K') {
            $pricequery = 'price BETWEEN 30000 AND 100000';
        } else if ($filterByPrice == '> 100K') {
            $pricequery = 'price > 100000';
        }

        $initSelection = 'SELECT 
            product.id AS product_id,
            product.name AS product_name,
            product.image,
            product.description,
            category.name AS category_name,
            price,
            stock
        FROM product
        INNER JOIN category ON product.idCategory = category.id';
        if (isset($query)) {
            if (is_numeric($query)) {
                if (isset($filterByCategory)) {
                    if (isset($filterByPrice)) {
                        if (isset($orderByPrice)) {
                            $this->db->query($initSelection . ' WHERE (product.name LIKE :likeQuery OR price = :query) AND category.name LIKE :filterCategory AND ' . $pricequery . ' AND stock > 0 ORDER BY price ' . $orderByPrice);
                            $this->db->bind(':query', $query);
                            $this->db->bind(':likeQuery', $likeQuery);
                            $this->db->bind(':filterCategory', $filterCategory);
                        } else {
                            $this->db->query($initSelection . ' WHERE (product.name LIKE :likeQuery OR price = :query) AND category.name LIKE :filterCategory AND ' . $pricequery . ' AND stock > 0 ORDER BY product.name ' . $orderByName);
                            $this->db->bind(':query', $query);
                            $this->db->bind(':likeQuery', $likeQuery);
                            $this->db->bind(':filterCategory', $filterCategory);
                        }
                    } else {
                        if (isset($orderByPrice)) {
                            $this->db->query($initSelection . ' WHERE (product.name LIKE :likeQuery OR price = :query) AND category.name LIKE :filterCategory AND stock > 0 ORDER BY price ' . $orderByPrice);
                            $this->db->bind(':query', $query);
                            $this->db->bind(':likeQuery', $likeQuery);
                            $this->db->bind(':filterCategory', $filterCategory);
                        } else {
                            $this->db->query($initSelection . ' WHERE (product.name LIKE :likeQuery OR price = :query) AND category.name LIKE :filterCategory AND stock > 0 ORDER BY product.name ' . $orderByName);
                            $this->db->bind(':query', $query);
                            $this->db->bind(':likeQuery', $likeQuery);
                            $this->db->bind(':filterCategory', $filterCategory);
                        }
                    }
                } else {
                    if (isset($filterByPrice)) {
                        if (isset($orderByPrice)) {
                            $this->db->query($initSelection . ' WHERE (product.name LIKE :likeQuery OR category.name LIKE :likeQuery OR price = :query) AND ' . $pricequery . ' AND stock > 0 ORDER BY price ' . $orderByPrice);
                            $this->db->bind(':query', $query);
                            $this->db->bind(':likeQuery', $likeQuery);
                        } else {
                            $this->db->query($initSelection . ' WHERE (product.name LIKE :likeQuery OR category.name LIKE :likeQuery OR price = :query) AND ' . $pricequery . ' AND stock > 0 ORDER BY product.name ' . $orderByName);
                            $this->db->bind(':query', $query);
                            $this->db->bind(':likeQuery', $likeQuery);
                        }
                    } else {
                        if (isset($orderByPrice)) {
                            $this->db->query($initSelection . ' WHERE (product.name LIKE :likeQuery OR category.name LIKE :likeQuery OR price = :query) AND stock > 0 ORDER BY price ' . $orderByPrice);
                            $this->db->bind(':query', $query);
                            $this->db->bind(':likeQuery', $likeQuery);
                        } else{
                            $this->db->query($initSelection . ' WHERE (product.name LIKE :likeQuery OR category.name LIKE :likeQuery OR price = :query) AND stock > 0 ORDER BY product.name ' . $orderByName);
                            $this->db->bind(':query', $query);
                            $this->db->bind(':likeQuery', $likeQuery);
                        }
                    }
                }
            } else {
                if (isset($filterByCategory)) {
                    if (isset($filterByPrice)) {
                        if (isset($orderByPrice)) {
                            $this->db->query($initSelection . ' WHERE product.name LIKE :likeQuery AND category.name LIKE :filterCategory AND ' . $pricequery . ' AND stock > 0 ORDER BY price ' . $orderByPrice);
                            $this->db->bind(':likeQuery', $likeQuery);
                            $this->db->bind(':filterCategory', $filterCategory);
                        } else {
                            $this->db->query($initSelection . ' WHERE product.name LIKE :likeQuery AND category.name LIKE :filterCategory AND '. $pricequery . ' AND stock > 0 ORDER BY product.name '. $orderByName);
                            $this->db->bind(':likeQuery', $likeQuery);
                            $this->db->bind(':filterCategory', $filterCategory);
                        }
                    } else {
                        if (isset($orderByPrice)) {
                            $this->db->query($initSelection . ' WHERE product.name LIKE :likeQuery AND category.name LIKE :filterCategory AND stock > 0 ORDER BY price ' . $orderByPrice);
                            $this->db->bind(':likeQuery', $likeQuery);
                            $this->db->bind(':filterCategory', $filterCategory);
                        } else {
                            $this->db->query($initSelection . ' WHERE product.name LIKE :likeQuery AND category.name LIKE :filterCategory AND stock > 0 ORDER BY product.name ' . $orderByName);
                            $this->db->bind(':likeQuery', $likeQuery);
                            $this->db->bind(':filterCategory', $filterCategory);
                        }
                    }
                } else {
                    if (isset($orderByPrice)) {
                        $this->db->query($initSelection . ' WHERE (product.name LIKE :likeQuery OR category.name LIKE :likeQuery) AND stock > 0 ORDER BY price ' . $orderByPrice);
                        $this->db->bind(':likeQuery', $likeQuery);
                    } else {
                        $this->db->query($initSelection . ' WHERE (product.name LIKE :likeQuery OR category.name LIKE :likeQuery) AND stock > 0 ORDER BY product.name ' . $orderByName);
                        $this->db->bind(':likeQuery', $likeQuery);
                    }
                }
            }
        } else {
            if (isset($filterByCategory)) {
                if (isset($filterByPrice)) {
                    if (isset($orderByPrice)) {
                        $this->db->query($initSelection . ' WHERE category.name LIKE :filterCategory AND ' . $pricequery . ' AND stock > 0 ORDER BY price ' . $orderByPrice);
                        $this->db->bind(':filterCategory', $filterCategory);
                    } else {
                        $this->db->query($initSelection . ' WHERE category.name LIKE :filterCategory AND ' . $pricequery . ' AND stock > 0 ORDER BY product.name ' . $orderByName);
                        $this->db->bind(':filterCategory', $filterCategory);
                    }
                } else {
                    if (isset($orderByPrice)) {
                        $this->db->query($initSelection . ' WHERE category.name LIKE :filterCategory AND stock > 0 ORDER BY price ' . $orderByPrice);
                        $this->db->bind(':filterCategory', $filterCategory);
                    } else {
                        $this->db->query($initSelection . ' WHERE category.name LIKE :filterCategory AND stock > 0 ORDER BY product.name ' . $orderByName);
                        $this->db->bind(':filterCategory', $filterCategory);
                    }
                }
            } else {
                if (isset($filterByPrice)) {
                    if (isset($orderByPrice)) {
                        $this->db->query($initSelection . ' WHERE ' . $pricequery . ' AND stock > 0 ORDER BY price ' . $orderByPrice);
                    } else {
                        $this->db->query($initSelection . ' WHERE ' . $pricequery . ' AND stock > 0 ORDER BY product.name ' . $orderByName);
                    }
                } else {
                    if (isset($orderByPrice)) {
                        $this->db->query($initSelection . ' WHERE stock > 0 ORDER BY price ' . $orderByPrice);
                    } else {
                        $this->db->query($initSelection . ' WHERE stock > 0 ORDER BY product.name ' . $orderByName);
                    }
                }
            }
        }

        try {
            $this->db->execute();
            return $this->db->resultSet();
        } catch (PDOException $e) {
            return  false;
        }
    }

    public function updateStock($product_id, $amount) {
        $this->db->query('UPDATE product SET stock = stock - :amount WHERE id = :id');
        $this->db->bind(':amount', $amount);
        $this->db->bind(':id', $product_id);
        
        try {
            return $this->db->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
}