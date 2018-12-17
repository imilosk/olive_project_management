<?php

require_once __DIR__ . '/../settings/DBInit.php';

class Organisation {

    const TABLE_NAME = 'organisationuser';

    /*public static function get_all() {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT * FROM {$table}");
        $statement->execute();
        return $statement->fetchAll();
    }*/

    public static function getProjects($idUser) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT idProject,name,desc FROM {$table} 
                                    INNER JOIN organisations as  org on org.id=={$table}.idProject
                                    WHERE idUser = :idUser");
        $statement->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch();
    }

    public static function getUsers($idProject) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT idUser,username FROM {$table} 
                                    INNER JOIN users as u on u.id=={$table}.idUser
                                    WHERE idProject = :idProject");
        $statement->bindParam(":idProject", $idProject, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch();
    }

    public static function insert($idUser, $idProject) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("INSERT INTO {$table} (idUser,idProject)
            VALUES (:idUser,:idProject)");
        $statement->bindParam(":idUser", $idUser);
        $statement->bindParam(":idProject", $idProject);
        $statement->execute();
    }
    public static function deleteUser($idUser) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("DELETE FROM {$table} WHERE idUser = :idUser");
        $statement->bindParam(":idUser", $idUserd);
        $statement->execute();
    } 
}