<?php
require_once(LIB_PATH . DS . 'database.php');

class Promo {
    protected static $tblname = "tblpromopro";

    function dbfields() {
        global $pdo;
        $stmt = $pdo->prepare("DESCRIBE " . self::$tblname);
        $stmt->execute();
        $fields = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $fields;
    }

    function listofpromo() {
        global $pdo;
        $sql = "SELECT * FROM " . self::$tblname;
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    function single_promo($id = "") {
        global $pdo;
        $sql = "SELECT * FROM " . self::$tblname . " WHERE PROMOID = :id LIMIT 1";
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
        // PDO handles sanitization via prepared statements, so just return attributes
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
        $success = $stmt->execute(array_combine($placeholders, array_values($attributes)));
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
        $sql = "UPDATE " . self::$tblname . " SET " . implode(", ", $fields) . " WHERE PROID = :id";
        $attributes['id'] = $id;
        $stmt = $pdo->prepare($sql);
        return $stmt->execute($attributes);
    }

    public function delete($id = 0) {
        global $pdo;
        $sql = "DELETE FROM " . self::$tblname . " WHERE PROID = :id LIMIT 1";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
?>