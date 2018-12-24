<?php

require_once __DIR__ . '/../settings/DBInit.php';

class Task {

    const TABLE_NAME = 'tasks';

/*
    public static function get_all($idProject) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT * FROM {$table} WHERE idProject = :idProject");
        $statement->bindParam(":idProject", $idProject, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }
*/

    public static function get($id) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare(" SELECT name 
                                    FROM {$table} 
                                    WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch();
    }

    public static function insert($name, $idProject) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare(" INSERT INTO {$table} (name, idProject)
                                    VALUES (:name,:idProject)");
        $statement->bindParam(":name", $name);
        $statement->bindParam(":idProject", $idProject);
        $statement->execute();
    }

    public static function update($id, $name) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare(" UPDATE {$table} SET 
                                    name = :name
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

    public static function get_project_tasks($idProject) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare(" SELECT t.id,t.name
                                    FROM {$table} AS t
                                    INNER JOIN projects AS p ON t.idProject=p.id
                                    WHERE p.id = :idProject");
        $statement->bindParam(":idProject", $idProject, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }

/*
    public static function get_user_tasks($idUser, $idOrganisation) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare(" SELECT t.id,t.name
                                    FROM {$table} AS t
                                    INNER JOIN userprojects AS up ON p.id=up.idProject
                                    WHERE up.idUser = :idUser AND p.idOrganisation = :idOrganisation");
        $statement->bindParam(":idOrganisation", $idOrganisation, PDO::PARAM_INT);
        $statement->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }
*/
    
}