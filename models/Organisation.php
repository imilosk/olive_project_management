<?php

require_once __DIR__ . '/../settings/DBInit.php';

class Organisation {

    const TABLE_NAME = 'organisations';

    public static function get_all() {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT * FROM {$table}");
        $statement->execute();
        return $statement->fetchAll();
    }

    public static function get($id) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT name FROM {$table} WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch();
    }

    public static function insert($name) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("INSERT INTO {$table} (name)
            VALUES (:name)");
        $statement->bindParam(":name", $name);
        $statement->execute();
    }

    public static function update($id, $name) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("UPDATE {$table} SET 
            username = :name, 
            WHERE id = :id");
        $statement->bindParam(":name", $name);
        $statement->bindParam(":id", $id);
        $statement->execute();
    }

    public static function delete($id) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("DELETE FROM {$table} WHERE id = :id");
        $statement->bindParam(":id", $id);
        $statement->execute();
    } 
}