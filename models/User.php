<?php

require_once __DIR__ . '/../settings/DBInit.php';

class User {

    const TABLE_NAME = 'users';

    public static function get_all() {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT email 
                                   FROM {$table}");
        $statement->execute();
        return $statement->fetchAll();
    }

    public static function get($id) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT email
                                   FROM {$table}
                                   WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch();
    }

    public static function getByEmail($email) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT email
                                   FROM {$table}
                                   WHERE email = :email");
        $statement->bindParam(":email", $email, PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch();
    }

    public static function get_all_users_in_organisation($idOrganisation) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT u.id, u.email
                                   FROM {$table} AS u
                                   INNER JOIN organisationsusers AS ou ON u.id=ou.idUser
                                   WHERE ou.idOrganisation = :idOrganisation");
        $statement->bindParam(":idOrganisation", $idOrganisation, PDO::PARAM_INT);  
        $statement->execute();                         
        return $statement->fetchAll();
    }

    public static function get_all_users_in_project($idProject) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT u.id, u.email
                                   FROM {$table} AS u
                                   INNER JOIN userprojects AS up ON u.id=up.idUser
                                   WHERE up.idProject = :idProject");
        $statement->bindParam(":idProject", $idProject, PDO::PARAM_INT);  
        $statement->execute();                         
        return $statement->fetchAll();
    }

    public static function get_all_users_in_task($idTask) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT u.id, u.email
                                   FROM {$table} AS u
                                   INNER JOIN tasksusersprojects AS tup ON u.id=tup.idUser
                                   WHERE tup.idTask = :idTask");
        $statement->bindParam(":idTask", $idTask, PDO::PARAM_INT);  
        $statement->execute();                         
        return $statement->fetchAll();
    }

    /*
    public static function insert($username) {

    }

    public static function update($id, $username) {
    }

    public static function delete($id) {

    }
    */

}
