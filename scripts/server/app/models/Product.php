<?php

class Product {
    private $table = 'product';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function show10products() {
        $this->db->query('SELECT * FROM ' . $this->table . ' ORDER BY name LIMIT 10');

        try {
            return $this->db->resultSet();
        } catch (PDOException $e) {
            return  false;
        }
    }

    public function queryProduct($query, $orderByPrice, $orderByName, $filterByCategory){
        $likeQuery = '%' . $query . '%';
        $filterCategory = '%' . $filterByCategory . '%';
        if (isset($query)) {
            if (is_numeric($query)) {
                if (isset($filterByCategory)) {
                    if (isset($orderByPrice)) {
                        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE ((name LIKE :likeQuery OR price = :query ) AND category like :filterCategory) ORDER BY price ' . $orderByPrice);
                        $this->db->bind(':query', $query);
                        $this->db->bind(':likeQuery', $likeQuery);
                        $this->db->bind(':filterCategory', $filterCategory);
                    } else {
                        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE ((name LIKE :likeQuery OR price = :query ) AND category like :filterCategory) ORDER BY name ' . $orderByName);
                        $this->db->bind(':query', $query);
                        $this->db->bind(':likeQuery', $likeQuery);
                        $this->db->bind(':filterCategory', $filterCategory);
                    }
                } else {
                    if (isset($orderByPrice)) {
                        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE (name LIKE :likeQuery OR price = :query ) ORDER BY price ' . $orderByPrice);
                        $this->db->bind(':query', $query);
                        $this->db->bind(':likeQuery', $likeQuery);
                    } else{
                        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE (name LIKE :likeQuery OR price = :query ) ORDER BY name ' . $orderByName);
                        $this->db->bind(':query', $query);
                        $this->db->bind(':likeQuery', $likeQuery);
                    }
                }
            } else {
                if (isset($filterByCategory)) {
                    if (isset($orderByPrice)) {
                        $this->db->query("SELECT * FROM " . $this->table . " WHERE (name LIKE :likeQuery) AND category LIKE :filterCategory ORDER BY price " . $orderByPrice);
                        $this->db->bind(':likeQuery', $likeQuery);
                        $this->db->bind(':filterCategory', $filterCategory);
                    } else{
                        $this->db->query("SELECT * FROM " . $this->table . " WHERE (name LIKE :likeQuery) AND category LIKE :filterCategory ORDER BY name " . $orderByName);
                        $this->db->bind(':likeQuery', $likeQuery);
                        $this->db->bind(':filterCategory', $filterCategory);
                    }
                } else {
                    if (isset($orderByPrice)) {
                        $this->db->query("SELECT * FROM " . $this->table . " WHERE (name LIKE :likeQuery) ORDER BY price " . $orderByPrice);
                        $this->db->bind(':likeQuery', $likeQuery);
                    } else {
                        $this->db->query("SELECT * FROM " . $this->table . " WHERE (name LIKE :likeQuery) ORDER BY name " . $orderByName);
                        $this->db->bind(':likeQuery', $likeQuery);
                    }
                }
            }
        } else{
            if (isset($filterByCategory)) {
                if (isset($orderByPrice)) {
                    $this->db->query('SELECT * FROM ' . $this->table . ' WHERE category LIKE :filterCategory ORDER BY price ' . $orderByPrice);
                    $this->db->bind(':filterCategory', $filterCategory);
                } else {
                    $this->db->query('SELECT * FROM ' . $this->table . ' WHERE category LIKE :filterCategory ORDER BY name ' . $orderByName);
                    $this->db->bind(':filterCategory', $filterCategory);
                }
            } else {
                if(isset($orderByPrice)) {
                    $this->db->query('SELECT * FROM ' . $this->table . ' ORDER BY price ' . $orderByPrice);
                } else {
                    $this->db->query('SELECT * FROM ' . $this->table . ' ORDER BY name ' . $orderByName);
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