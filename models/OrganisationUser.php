<?php

require_once __DIR__ . '/../settings/DBInit.php';

class OrganisationUser {

    const TABLE_NAME = 'organisationsusers';

    public static function getUserOrganisations($idUser) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT idOrganisation,name FROM {$table} 
                                    INNER JOIN organisations as org on org.id={$table}.idOrganisation
                                    WHERE {$table}.idUser = :idUser
                                    ORDER BY name desc" );
        $statement->bindParam(":idUser", $idUser, PDO::PARAM_INT);
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