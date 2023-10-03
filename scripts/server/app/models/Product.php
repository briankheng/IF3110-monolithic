<?php

class Product {
    private $table = 'product';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function showAllproducts() {
        // SQL query with explicit JOIN and ordering by name.
        $sql = 'SELECT 
                product.id AS product_id,
                product.name AS product_name,
                product.image,
                product.video,
                product.description,
                category.name AS category_name,
                product.price,
                product.stock
            FROM product
            INNER JOIN category ON product.idCategory = category.id
            ORDER BY product.name';

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

    public function queryProduct($query, $orderByPrice, $orderByName, $filterByCategory){
        $likeQuery = '%' . $query . '%';
        $filterCategory = '%' . $filterByCategory . '%';
        $initSelection = 'SELECT 
            product.id AS product_id,
            product.name AS product_name,
            product.image,
            product.video,
            product.description,
            category.name AS category_name,
            product.price,
            product.stock
        FROM product
        INNER JOIN category ON product.idCategory = category.id';
        if (isset($query)) {
            if (is_numeric($query)) {
                if (isset($filterByCategory)) {
                    if (isset($orderByPrice)) {
                        $this->db->query($initSelection . ' WHERE ((product.name LIKE :likeQuery OR price = :query ) AND category.name like :filterCategory) ORDER BY price ' . $orderByPrice);
                        $this->db->bind(':query', $query);
                        $this->db->bind(':likeQuery', $likeQuery);
                        $this->db->bind(':filterCategory', $filterCategory);
                    } else {
                        $this->db->query($initSelection . ' WHERE ((product.name LIKE :likeQuery OR price = :query ) AND category.name like :filterCategory) ORDER BY product.name ' . $orderByName);
                        $this->db->bind(':query', $query);
                        $this->db->bind(':likeQuery', $likeQuery);
                        $this->db->bind(':filterCategory', $filterCategory);
                    }
                } else {
                    if (isset($orderByPrice)) {
                        $this->db->query($initSelection . ' WHERE (product.name LIKE :likeQuery OR price = :query ) ORDER BY price ' . $orderByPrice);
                        $this->db->bind(':query', $query);
                        $this->db->bind(':likeQuery', $likeQuery);
                    } else{
                        $this->db->query($initSelection . ' WHERE (product.name LIKE :likeQuery OR price = :query ) ORDER BY product.name ' . $orderByName);
                        $this->db->bind(':query', $query);
                        $this->db->bind(':likeQuery', $likeQuery);
                    }
                }
            } else {
                if (isset($filterByCategory)) {
                    if (isset($orderByPrice)) {
                        $this->db->query($initSelection . " WHERE (product.name LIKE :likeQuery) AND category.name LIKE :filterCategory ORDER BY price " . $orderByPrice);
                        $this->db->bind(':likeQuery', $likeQuery);
                        $this->db->bind(':filterCategory', $filterCategory);
                    } else{
                        $this->db->query($initSelection . " WHERE (product.name LIKE :likeQuery) AND category.name LIKE :filterCategory ORDER BY product.name " . $orderByName);
                        $this->db->bind(':likeQuery', $likeQuery);
                        $this->db->bind(':filterCategory', $filterCategory);
                    }
                } else {
                    if (isset($orderByPrice)) {
                        $this->db->query($initSelection . " WHERE (product.name LIKE :likeQuery) ORDER BY price " . $orderByPrice);
                        $this->db->bind(':likeQuery', $likeQuery);
                    } else {
                        $this->db->query($initSelection . " WHERE (product.name LIKE :likeQuery) ORDER BY product.name " . $orderByName);
                        $this->db->bind(':likeQuery', $likeQuery);
                    }
                }
            }
        } else{
            if (isset($filterByCategory)) {
                if (isset($orderByPrice)) {
                    $this->db->query($initSelection . ' WHERE category.name LIKE :filterCategory ORDER BY price ' . $orderByPrice);
                    $this->db->bind(':filterCategory', $filterCategory);
                } else {
                    $this->db->query($initSelection . ' WHERE category.name LIKE :filterCategory ORDER BY product.name ' . $orderByName);
                    $this->db->bind(':filterCategory', $filterCategory);
                }
            } else {
                if(isset($orderByPrice)) {
                    $this->db->query($initSelection . ' ORDER BY price ' . $orderByPrice);
                } else {
                    $this->db->query($initSelection . ' ORDER BY product.name ' . $orderByName);
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
}