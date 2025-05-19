<?php
require_once(LIB_PATH . DS . 'database.php');

class User {
    protected static $tblname = "tbluseraccount";

    function dbfields() {
        global $pdo;
        $stmt = $pdo->prepare("DESCRIBE " . self::$tblname);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    function listofuser() {
        global $pdo;
        $sql = "SELECT * FROM " . self::$tblname;
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    function find_user($id = "", $user_name = "") {
        global $pdo;
        $sql = "SELECT * FROM " . self::$tblname . " WHERE USERID = :id OR U_USERNAME = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id, ':username' => $user_name]);
        return $stmt->rowCount();
    }

    static function userAuthentication($U_USERNAME, $h_pass) {
        global $pdo;
        $sql = "SELECT * FROM `tbluseraccount` WHERE `U_USERNAME` = :username AND `U_PASS` = :pass";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':username' => $U_USERNAME, ':pass' => $h_pass]);
        $user_found = $stmt->fetch(PDO::FETCH_OBJ);
        if ($user_found) {
            $_SESSION['USERID']    = $user_found->USERID;
            $_SESSION['U_NAME']    = $user_found->U_NAME;
            $_SESSION['U_USERNAME']= $user_found->U_USERNAME;
            $_SESSION['U_PASS']    = $user_found->U_PASS;
            $_SESSION['U_ROLE']    = $user_found->U_ROLE;
            return true;
        } else {
            return false;
        }
    }

    function single_user($id = "") {
        global $pdo;
        $sql = "SELECT * FROM " . self::$tblname . " WHERE USERID = :id LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    static function instantiate($record) {
        $object = new self;
        foreach ($record as $attribute => $value) {
            if ($object->has_attribute($attribute)) {
                $object->$attribute = $value;
            }
        }
        return $object;
    }

    private function has_attribute($attribute) {
        return array_key_exists($attribute, $this->attributes());
    }

    protected function attributes() {
        $attributes = [];
        foreach ($this->dbfields() as $field) {
            if (property_exists($this, $field)) {
                $attributes[$field] = $this->$field;
            }
        }
        return $attributes;
    }

    protected function sanitized_attributes() {
        // PDO handles sanitization via prepared statements
        return $this->attributes();
    }

    public function save() {
        return isset($this->id) ? $this->update($this->id) : $this->create();
    }

    public function create() {
        global $pdo;
        $attributes = $this->sanitized_attributes();
        $fields = array_keys($attributes);
        $placeholders = array_map(function ($field) { return ':' . $field; }, $fields);

        $sql = "INSERT INTO " . self::$tblname . " (" . implode(", ", $fields) . ") VALUES (" . implode(", ", $placeholders) . ")";
        $stmt = $pdo->prepare($sql);
        $params = [];
        foreach ($fields as $field) {
            $params[":$field"] = $attributes[$field];
        }
        $success = $stmt->execute($params);
        if ($success) {
            $this->id = $pdo->lastInsertId();
            return true;
        }
        return false;
    }

    public function update($id = 0) {
        global $pdo;
        $attributes = $this->sanitized_attributes();
        $fields = [];
        foreach ($attributes as $key => $value) {
            $fields[] = "{$key} = :{$key}";
        }
        $sql = "UPDATE " . self::$tblname . " SET " . implode(", ", $fields) . " WHERE USERID = :id";
        $attributes['id'] = $id;
        $stmt = $pdo->prepare($sql);
        return $stmt->execute($attributes);
    }

    public function delete($id = 0) {
        global $pdo;
        $sql = "DELETE FROM " . self::$tblname . " WHERE USERID = :id LIMIT 1";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
?>