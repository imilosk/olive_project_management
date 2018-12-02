<?php

require_once __DIR__ . '/../settings/DBInit.php';

class Project {

    const TABLE_NAME = 'projects';

    public static function get_all() {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT name,description,idOrganisation FROM {$table}");
        $statement->execute();
        return $statement->fetchAll();
    }

    public static function get($id) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT name,description FROM {$table} WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch();
    }

    public static function insert($name,$description, $idOrganisation) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("INSERT INTO {$table} (name,description,idOrganisation)
            VALUES (:name,:description,:idOrganisation)");
        $statement->bindParam(":name", $name);
        $statement->bindParam(":description", $description);
        $statement->bindParam(":idOrganisation", $idOrganisation);
        $statement->execute();
    }

    public static function update($id, $name, $description) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("UPDATE {$table} SET 
            username = :name, 
            rating = :description
            WHERE id = :id");
        $statement->bindParam(":name", $name);
        $statement->bindParam(":description", $description);
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