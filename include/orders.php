<?php

require_once(LIB_PATH . DS . 'database.php');

class Order {
    protected static $tblname = "tblorder";

    // Get all database fields for the table
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

    // List all orders
    function listoforders() {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM " . self::$tblname);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get a single order by ORDERID
    function single_orders($id = "") {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM " . self::$tblname . " WHERE ORDERID = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // Instantiate an Order object from a record
    static function instantiate($record) {
        $object = new self;
        foreach ($record as $attribute => $value) {
            if ($object->has_attribute($attribute)) {
                $object->$attribute = $value;
            }
        }
        return $object;
    }

    // Check if the object has a given attribute
    private function has_attribute($attribute) {
        return array_key_exists($attribute, $this->attributes());
    }

    // Get object attributes that match db fields
    protected function attributes() {
        $attributes = [];
        foreach ($this->dbfields() as $field) {
            if (property_exists($this, $field)) {
                $attributes[$field] = $this->$field;
            }
        }
        return $attributes;
    }

    // Sanitized attributes (PDO handles this)
    protected function sanitized_attributes() {
        return $this->attributes();
    }

    // Save (create or update)
    public function save() {
        return isset($this->id) ? $this->update($this->id) : $this->create();
    }

    // Create a new order
    public function create() {
        global $pdo;
        $attributes = $this->sanitized_attributes();
        if (empty($attributes)) return false;
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

    // Update order by ORDERNUMBER (partial update)
    public function pupdate($id = 0) {
        global $pdo;
        $attributes = $this->sanitized_attributes();
        if (empty($attributes)) return false;
        $attribute_pairs = [];
        foreach ($attributes as $key => $value) {
            $attribute_pairs[] = "{$key} = :{$key}";
        }
        $sql = "UPDATE " . self::$tblname . " SET " . implode(", ", $attribute_pairs) . " WHERE ORDERNUMBER = :id";
        $attributes['id'] = $id;
        $stmt = $pdo->prepare($sql);
        return $stmt->execute($attributes);
    }

    // Update order by ORDERID (full update)
    public function update($id = 0) {
        global $pdo;
        $attributes = $this->sanitized_attributes();
        if (empty($attributes)) return false;
        $attribute_pairs = [];
        foreach ($attributes as $key => $value) {
            $attribute_pairs[] = "{$key} = :{$key}";
        }
        $sql = "UPDATE " . self::$tblname . " SET " . implode(", ", $attribute_pairs) . " WHERE ORDERID = :id";
        $attributes['id'] = $id;
        $stmt = $pdo->prepare($sql);
        return $stmt->execute($attributes);
    }

    // Delete order by ORDERNUMBER
    public function pdelete($id = 0) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM " . self::$tblname . " WHERE ORDERNUMBER = :id LIMIT 1");
        return $stmt->execute([':id' => $id]);
    }

    // Delete order by ORDERID
    public function delete($id = 0) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM " . self::$tblname . " WHERE ORDERID = :id LIMIT 1");
        return $stmt->execute([':id' => $id]);
    }
}
?>