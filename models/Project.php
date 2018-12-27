<?php

require_once __DIR__ . '/../settings/DBInit.php';

class Project {

    const TABLE_NAME = 'projects';

/*
    public static function get_all() {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT id,name,description,idOrganisation FROM {$table}");
        $statement->execute();
        return $statement->fetchAll();
    }
*/

    public static function get($id) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare(" SELECT name,description 
                                    FROM {$table} 
                                    WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch();
    }

    public static function get_organisation_projects($idOrganisation) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare(" SELECT p.id,p.name,p.description 
                                    FROM {$table} AS p
                                    INNER JOIN organisations AS o ON p.idOrganisation=o.id
                                    WHERE o.id = :idOrganisation");
        $statement->bindParam(":idOrganisation", $idOrganisation, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }

    public static function insert($name, $description, $idOrganisation) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("INSERT INTO {$table} (name,description,idOrganisation)
            VALUES (:name,:description,:idOrganisation)");
        $statement->bindParam(":name", $name);
        $statement->bindParam(":description", $description);
        $statement->bindParam(":idOrganisation", $idOrganisation);
        $statement->execute();
        return $db->lastInsertId();
    }

    public static function update($id, $name, $description) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare(" UPDATE {$table} SET 
                                    name = :name, 
                                    description = :description
                                    WHERE id = :id");
        $statement->bindParam(":name", $name);
        $statement->bindParam(":description", $description);
        $statement->bindParam(":id", $id);
        $statement->execute();
        return "true";
    }

    public static function delete($id) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("DELETE FROM {$table} WHERE id = :id");
        $statement->bindParam(":id", $id);
        $statement->execute();
        return "true";
    } 

    public static function get_user_projects($idUser, $idOrganisation) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare(" SELECT p.id,p.name,p.description 
                                    FROM {$table} AS p
                                    INNER JOIN userprojects AS up ON p.id=up.idProject
                                    WHERE up.idUser = :idUser AND p.idOrganisation = :idOrganisation");
        $statement->bindParam(":idOrganisation", $idOrganisation, PDO::PARAM_INT);
        $statement->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }
}