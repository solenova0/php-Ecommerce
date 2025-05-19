<?php
require_once(LIB_PATH.DS.'database.php');
class Autonumber {
    protected static $tblname = "tblautonumber";

    function dbfields () {
        global $pdo;
        $stmt = $pdo->prepare("DESCRIBE " . self::$tblname);
        $stmt->execute();
        $fields = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $fields[] = $row['Field'];
        }
        return $fields;
    }

    function listofautonumber(){
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM " . self::$tblname);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    function find_autonumber($name=""){
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM " . self::$tblname . " WHERE AUTOKEY = :name");
        $stmt->execute([':name' => $name]);
        return $stmt->rowCount();
    }

    function single_autonumber($autokey=""){
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM " . self::$tblname . " WHERE AUTOKEY = :autokey LIMIT 1");
        $stmt->execute([':autokey' => $autokey]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    function set_autonumber($id=""){
        global $pdo;
        $stmt = $pdo->prepare("SELECT concat(AUTOSTART,AUTOEND) AS 'AUTO' FROM " . self::$tblname . " WHERE AUTOKEY = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /*---Instantiation of Object dynamically---*/
    static function instantiate($record) {
        $object = new self;
        foreach($record as $attribute=>$value){
            if($object->has_attribute($attribute)) {
                $object->$attribute = $value;
            }
        }
        return $object;
    }

    private function has_attribute($attribute) {
        return array_key_exists($attribute, $this->attributes());
    }

    protected function attributes() {
        $attributes = array();
        foreach($this->dbfields() as $field) {
            if(property_exists($this, $field)) {
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
        $placeholders = array_map(function($field){ return ':' . $field; }, $fields);
        $sql = "INSERT INTO " . self::$tblname . " (" . implode(", ", $fields) . ") VALUES (" . implode(", ", $placeholders) . ")";
        $stmt = $pdo->prepare($sql);
        if($stmt->execute($attributes)) {
            $this->id = $pdo->lastInsertId();
            return true;
        } else {
            return false;
        }
    }

    public function update($id="") {
        global $pdo;
        $attributes = $this->sanitized_attributes();
        $attribute_pairs = [];
        foreach($attributes as $key => $value) {
            $attribute_pairs[] = "{$key} = :{$key}";
        }
        $sql = "UPDATE " . self::$tblname . " SET " . implode(", ", $attribute_pairs) . " WHERE AUTOKEY = :id";
        $attributes['id'] = $id;
        $stmt = $pdo->prepare($sql);
        return $stmt->execute($attributes);
    }

    public function auto_update($id="") {
        global $pdo;
        $sql = "UPDATE " . self::$tblname . " SET AUTOEND = AUTOEND + AUTOINC WHERE AUTOKEY = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function delete($id="") {
        global $pdo;
        $sql = "DELETE FROM " . self::$tblname . " WHERE AUTOKEY = :id LIMIT 1";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
?>