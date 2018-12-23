<?php
require_once __DIR__ . '/../settings/DBInit.php';

class OrganisationUser {
    const TABLE_NAME = 'organisationsusers';

    public static function get_user_organisations($idUser) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT idOrganisation, name FROM {$table} 
                                    INNER JOIN organisations as org on org.id={$table}.idOrganisation
                                    WHERE {$table}.idUser = :idUser
                                    ORDER BY name desc" );
        $statement->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }
    public static function insert($idOrganisation, $idUser) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("INSERT INTO {$table} (idUser, idOrganisation)
                                   VALUES (:idUser,:idOrganisation)");
        $statement->bindParam(":idUser", $idUser);
        $statement->bindParam(":idOrganisation", $idOrganisation, PDO::PARAM_INT);
        $statement->execute();
        return "true";
    }
    public static function delete($idOrganisation, $idUser) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("DELETE FROM {$table}
                                   WHERE idUser = :idUser
                                   AND idOrganisation = :idOrganisation");
        $statement->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        $statement->bindParam(":idOrganisation", $idOrganisation, PDO::PARAM_INT);
        $statement->execute();
        return "true";
    } 
}