<?php

class Database {
    private $dbh;
    private $stmt;

    public function __construct() {
        require_once __DIR__ . '/../constants/base.php';
        $option = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

        try {
            $dsn = 'pgsql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME;
            $this->dbh = new PDO($dsn, DB_USER, DB_PASSWORD, $option);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function startTransaction() {
        try {
            $this->dbh->beginTransaction();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function commit() {
        try {
            $this->dbh->beginTransaction();
        } catch (PDOException $e) {
            return $this->dbh->commit();
        }
    }

    public function rollback() {
        try {
            $this->dbh->beginTransaction();
        } catch (PDOException $e) {
            return $this->dbh->rollBack();
        }
    }

    public function query($query) {
        $this->stmt = $this->dbh->prepare($query);
    }

    public function bind($param, $value, $type = null) {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }

        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute() {
        try {
            return $this->stmt->execute();
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function single() {
        try {
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            return false;
        }
    }
}
