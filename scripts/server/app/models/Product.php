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
                price,
                stock
            FROM product
            INNER JOIN category ON product.idCategory = category.id';

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

    public function queryProduct($query, $orderByPrice, $orderByName, $filterByCategory, $filterByPrice) {
        $likeQuery = '%' . $query . '%';
        $filterCategory = '%' . $filterByCategory . '%';
        $pricequery = NULL;
        if ($filterByPrice == "< 5K") {
            $pricequery = 'price < 5000';
        } else if ($filterByPrice == "5K - 30K") {
            $pricequery = 'price BETWEEN 5000 AND 30000';
        } else if ($filterByPrice == "30K - 100K") {
            $pricequery = 'price BETWEEN 30000 AND 100000';
        } else if ($filterByPrice == "> 100K") {
            $pricequery = 'price > 100000';
        }

        $initSelection = 'SELECT 
            product.id AS product_id,
            product.name AS product_name,
            product.image,
            product.video,
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
                            $this->db->query($initSelection . ' WHERE (product.name LIKE :likeQuery OR category.name LIKE :likeQuery OR price = :query) AND category.name like :filterCategory AND ' . $pricequery . ' ORDER BY price ' . $orderByPrice);
                            $this->db->bind(':query', $query);
                            $this->db->bind(':likeQuery', $likeQuery);
                            $this->db->bind(':filterCategory', $filterCategory);
                        } else {
                            $this->db->query($initSelection . ' WHERE (product.name LIKE :likeQuery OR category.name LIKE :likeQuery OR price = :query) AND category.name like :filterCategory AND ' . $pricequery . ' ORDER BY product.name ' . $orderByName);
                            $this->db->bind(':query', $query);
                            $this->db->bind(':likeQuery', $likeQuery);
                            $this->db->bind(':filterCategory', $filterCategory);
                        }
                    } else {
                        if (isset($orderByPrice)) {
                            $this->db->query($initSelection . ' WHERE (product.name LIKE :likeQuery OR category.name LIKE :likeQuery OR price = :query) AND category.name like :filterCategory ORDER BY price ' . $orderByPrice);
                            $this->db->bind(':query', $query);
                            $this->db->bind(':likeQuery', $likeQuery);
                            $this->db->bind(':filterCategory', $filterCategory);
                        } else {
                            $this->db->query($initSelection . ' WHERE (product.name LIKE :likeQuery OR category.name LIKE :likeQuery OR price = :query) AND category.name like :filterCategory ORDER BY product.name ' . $orderByName);
                            $this->db->bind(':query', $query);
                            $this->db->bind(':likeQuery', $likeQuery);
                            $this->db->bind(':filterCategory', $filterCategory);
                        }
                    }
                } else {
                    if (isset($filterByPrice)) {
                        if (isset($orderByPrice)) {
                            $this->db->query($initSelection . ' WHERE (product.name LIKE :likeQuery OR category.name LIKE :likeQuery OR price = :query) AND ' . $pricequery . ' ORDER BY price ' . $orderByPrice);
                            $this->db->bind(':query', $query);
                            $this->db->bind(':likeQuery', $likeQuery);
                        } else {
                            $this->db->query($initSelection . ' WHERE (product.name LIKE :likeQuery OR category.name LIKE :likeQuery OR price = :query) AND ' . $pricequery . ' ORDER BY product.name ' . $orderByName);
                            $this->db->bind(':query', $query);
                            $this->db->bind(':likeQuery', $likeQuery);
                        }
                    } else {
                        if (isset($orderByPrice)) {
                            $this->db->query($initSelection . ' WHERE (product.name LIKE :likeQuery OR category.name LIKE :likeQuery OR price = :query) ORDER BY price ' . $orderByPrice);
                            $this->db->bind(':query', $query);
                            $this->db->bind(':likeQuery', $likeQuery);
                        } else{
                            $this->db->query($initSelection . ' WHERE (product.name LIKE :likeQuery OR category.name LIKE :likeQuery OR price = :query) ORDER BY product.name ' . $orderByName);
                            $this->db->bind(':query', $query);
                            $this->db->bind(':likeQuery', $likeQuery);
                        }
                    }
                }
            } else {
                if (isset($filterByCategory)) {
                    if (isset($filterByPrice)) {
                        if (isset($orderByPrice)) {
                            $this->db->query($initSelection . " WHERE (product.name LIKE :likeQuery OR category.name LIKE :likeQuery) AND category.name LIKE :filterCategory AND ' . $pricequery . ' ORDER BY price " . $orderByPrice);
                            $this->db->bind(':likeQuery', $likeQuery);
                            $this->db->bind(':filterCategory', $filterCategory);
                        } else{
                            $this->db->query($initSelection . " WHERE (product.name LIKE :likeQuery OR category.name LIKE :likeQuery) AND category.name LIKE :filterCategory AND ' . $pricequery . ' ORDER BY product.name " . $orderByName);
                            $this->db->bind(':likeQuery', $likeQuery);
                            $this->db->bind(':filterCategory', $filterCategory);
                        }
                    } else {
                        if (isset($orderByPrice)) {
                            $this->db->query($initSelection . " WHERE (product.name LIKE :likeQuery OR category.name LIKE :likeQuery) AND category.name LIKE :filterCategory ORDER BY price " . $orderByPrice);
                            $this->db->bind(':likeQuery', $likeQuery);
                            $this->db->bind(':filterCategory', $filterCategory);
                        } else{
                            $this->db->query($initSelection . " WHERE (product.name LIKE :likeQuery OR category.name LIKE :likeQuery) AND category.name LIKE :filterCategory ORDER BY product.name " . $orderByName);
                            $this->db->bind(':likeQuery', $likeQuery);
                            $this->db->bind(':filterCategory', $filterCategory);
                        }
                    }
                } else {
                    if (isset($orderByPrice)) {
                        $this->db->query($initSelection . " WHERE (product.name LIKE :likeQuery OR category.name LIKE :likeQuery) ORDER BY price " . $orderByPrice);
                        $this->db->bind(':likeQuery', $likeQuery);
                    } else {
                        $this->db->query($initSelection . " WHERE (product.name LIKE :likeQuery OR category.name LIKE :likeQuery) ORDER BY product.name " . $orderByName);
                        $this->db->bind(':likeQuery', $likeQuery);
                    }
                }
            }
        } else {
            if (isset($filterByCategory)) {
                if (isset($filterByPrice)) {
                    if (isset($orderByPrice)) {
                        $this->db->query($initSelection . ' WHERE category.name LIKE :filterCategory AND ' . $pricequery . ' ORDER BY price ' . $orderByPrice);
                        $this->db->bind(':filterCategory', $filterCategory);
                    } else {
                        $this->db->query($initSelection . ' WHERE category.name LIKE :filterCategory AND ' . $pricequery . ' ORDER BY product.name ' . $orderByName);
                        $this->db->bind(':filterCategory', $filterCategory);
                    }
                } else {
                    if (isset($orderByPrice)) {
                        $this->db->query($initSelection . ' WHERE category.name LIKE :filterCategory ORDER BY price ' . $orderByPrice);
                        $this->db->bind(':filterCategory', $filterCategory);
                    } else {
                        $this->db->query($initSelection . ' WHERE category.name LIKE :filterCategory ORDER BY product.name ' . $orderByName);
                        $this->db->bind(':filterCategory', $filterCategory);
                    }
                }
            } else {
                if (isset($filterByPrice)) {
                    if (isset($orderByPrice)) {
                        $this->db->query($initSelection . ' WHERE ' . $pricequery . ' ORDER BY price ' . $orderByPrice);
                        $this->db->bind(':pricequery', $pricequery);
                    } else {
                        $this->db->query($initSelection . ' WHERE ' . $pricequery . ' ORDER BY product.name ' . $orderByName);
                        $this->db->bind(':pricequery', $pricequery);
                    }
                } else {
                    if (isset($orderByPrice)) {
                        $this->db->query($initSelection . ' ORDER BY price ' . $orderByPrice);
                    } else {
                        $this->db->query($initSelection . ' ORDER BY product.name ' . $orderByName);
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
}