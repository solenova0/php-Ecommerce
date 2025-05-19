<?php

require_once(LIB_PATH.DS."config.php");

class Database {
    public $pdo;
    public $last_query;
    public $error_no = 0;
    public $error_msg = '';

    function __construct() {
        $this->open_connection();
    }

    public function open_connection() {
        try {
            $dsn = "mysql:host=" . server . ";dbname=" . database_name . ";charset=utf8";
            $this->pdo = new PDO($dsn, user, pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ]);
        } catch (PDOException $e) {
            echo "Problem in database connection! Contact administrator!<br>";
            echo $e->getMessage();
            exit();
        }
    }

    public function setQuery($sql='') {
        $this->last_query = $sql;
    }

    public function executeQuery($params = []) {
        try {
            $stmt = $this->pdo->prepare($this->last_query);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            $this->error_no = $e->getCode();
            $this->error_msg = $e->getMessage();
            return false;
        }
    }

public function loadResultList($key='') {
    $stmt = $this->executeQuery();
    $array = [];
    if ($stmt) {
        while ($row = $stmt->fetch()) {
            if ($key && isset($row->$key)) {
                $array[$row->$key] = $row;
            } else {
                $array[] = $row;
            }
        }
    }
    return $array;
}

    public function loadSingleResult() {
        $stmt = $this->executeQuery();
        return $stmt->fetch();
    }

    public function getFieldsOnOneTable($tbl_name) {
        $this->setQuery("DESC ".$tbl_name);
        $rows = $this->loadResultList();
        $f = [];
        foreach ($rows as $row) {
            $f[] = $row->Field;
        }
        return $f;
    }

    public function fetch_array($stmt) {
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function num_rows($stmt) {
        return $stmt->rowCount();
    }

    public function insert_id() {
        return $this->pdo->lastInsertId();
    }

    public function affected_rows($stmt) {
        return $stmt->rowCount();
    }

    public function escape_value($value) {
        // PDO handles escaping via prepared statements, but for legacy use:
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    public function close_connection() {
        $this->pdo = null;
    }
}

global $pdo;
$mydb = new Database();
$pdo = $mydb->pdo;
?>