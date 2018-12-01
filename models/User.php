<?php

require_once __DIR__ . '/../settings/DBInit.php';

class User {

    const TABLE_NAME = 'users';

    public static function get_all() {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT email FROM {$table}");
        $statement->execute();
        return $statement->fetchAll();
    }

    public static function get($id) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT username FROM {$table} WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch();
    }

    public static function insert($username) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("INSERT INTO {$table} (username)
            VALUES (:username)");
        $statement->bindParam(":username", $username);
        $statement->execute();
    }

    public static function update($id, $username, $rating) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("UPDATE {$table} SET 
            username = :username, 
            rating = :rating
            WHERE id = :id");
        $statement->bindParam(":username", $username);
        $statement->bindParam(":rating", $rating);
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
