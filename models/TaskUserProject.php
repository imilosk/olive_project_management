<?php

require_once __DIR__ . '/../settings/DBInit.php';

class TaskUserProject {

    const TABLE_NAME = 'tasksusersprojects';

/*
    public static function get_all($idUser) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT * FROM {$table} WHERE idUser = :idUser");
        $statement->bindParam(":idUser", $idProject, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }
*/

    public static function insert($idUser, $idTask, $idPSP) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare(" INSERT INTO {$table} (idUser,idTask,idPSP)
            						VALUES (:idUser,:idTask,:idPSP)");
        $statement->bindParam(":idUser", $idUser);
        $statement->bindParam(":idTask", $idTask);
        $statement->bindParam(":idPSP", $idPSP);
        $statement->execute();
    }

/*
    public static function update($idUser, $idTask, $idPSP) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("UPDATE {$table} SET 
            idPSP = :idPSP
            WHERE idUser = :idUser AND idTask = :idTask"  );
        $statement->bindParam(":idUser", $idUser);
        $statement->bindParam(":idTask", $idTask);
        $statement->bindParam(":idPSP", $idPSP);
        $statement->execute();
    }
*/

    public static function delete($idUser, $idTask) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare(" DELETE FROM {$table} 
        							WHERE idUser = :idUser 
        							AND idTask = :idTask");
        $statement->bindParam(":idUser", $idUser);
        $statement->bindParam(":idTask", $idTask);
        $statement->execute();
    } 

    public static function get_task_users($idTask) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare(" SELECT idUser, u.email
                                    FROM {$table} tup
                                    INNER JOIN Users u on u.id = tup.idUser
                                    WHERE tup.idTask = :idTask");
        $statement->bindParam(":idTask", $idTask, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }
}