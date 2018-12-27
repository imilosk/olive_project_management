<?php
require_once __DIR__ . '/../settings/DBInit.php';

class UserProject {
    const TABLE_NAME = 'userprojects';

    public static function insert($idProject, $idUser) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("INSERT INTO {$table} (idProject, idUser)
                                   VALUES (:idProject,:idUser)");
        $statement->bindParam(":idUser", $idUser);
        $statement->bindParam(":idProject", $idProject, PDO::PARAM_INT);
        $statement->execute();
        //return "true";
    }
    public static function delete($idProject, $idUser) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("DELETE FROM {$table}
                                   WHERE idUser = :idUser
                                   AND idProject = :idProject");
        $statement->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        $statement->bindParam(":idProject", $idProject, PDO::PARAM_INT);
        $statement->execute();
        return "true";
    } 
}