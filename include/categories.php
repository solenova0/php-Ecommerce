<?php

require_once(LIB_PATH.DS.'database.php');
class Category {
    protected static $tblname = "tblcategory";

    function dbfields() {
        global $pdo;
        $stmt = $pdo->prepare("DESCRIBE " . self::$tblname);
        $stmt->execute();
        $fields = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $fields[] = $row['Field'];
        }
        return $fields;
    }

    function listofcategory() {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM " . self::$tblname);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function find_category($id = "", $name = "") {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM " . self::$tblname . " WHERE CATEGID = :id OR CATEGORIES = :name");
        $stmt->execute([':id' => $id, ':name' => $name]);
        return $stmt->rowCount();
    }

    function single_category($id = "") {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM " . self::$tblname . " WHERE CATEGID = :id LIMIT 1");
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
        if ($stmt->execute(array_combine($placeholders, array_values($attributes)))) {
            $this->id = $pdo->lastInsertId();
            return true;
        }
        return false;
    }

    public function update($id = 0) {
        global $pdo;
        $attributes = $this->sanitized_attributes();
        $attribute_pairs = [];
        foreach ($attributes as $key => $value) {
            $attribute_pairs[] = "{$key} = :{$key}";
        }
        $sql = "UPDATE " . self::$tblname . " SET " . implode(", ", $attribute_pairs) . " WHERE CATEGID = :id";
        $attributes['id'] = $id;
        $stmt = $pdo->prepare($sql);
        return $stmt->execute($attributes);
    }

    public function delete($id = 0) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM " . self::$tblname . " WHERE CATEGID = :id LIMIT 1");
        return $stmt->execute([':id' => $id]);
    }
}
?>