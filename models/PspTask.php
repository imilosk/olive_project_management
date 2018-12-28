<?php

require_once __DIR__ . '/../settings/DBInit.php';

class PSPTask {

    const TABLE_NAME = 'psp_tasks ';

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
        $statement = $db->prepare(" SELECT *
                                    FROM {$table} 
                                    WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch();
    }


    public static function insert($idPhase, $idPSP, $start, $end, $pause, $description, $units, $estimatedtime, $estimatedunits) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare(" INSERT INTO {$table} (idPhase, idPSP, start, end, pause, description, units, estimatedtime, estimatedunits) VALUES (:idPhase, :idPSP, :start, :endtime, :pause, :description, :units, :estimatedtime, :estimatedunits)");
        $statement->bindParam(":idPhase", $idPhase);
        $statement->bindParam(":idPSP", $idPSP);
        $statement->bindParam(":start", $start);
        $statement->bindParam(":endtime", $end);
        $statement->bindParam(":pause", $pause);
        $statement->bindParam(":description", $description);
        $statement->bindParam(":units", $units);
        $statement->bindParam(":estimatedtime", $estimatedtime);
        $statement->bindParam(":estimatedunits", $estimatedunits);
        $statement->execute();
    }

    public static function delete($id) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("DELETE FROM {$table} WHERE id = :id");
        $statement->bindParam(":id", $id);
        $statement->execute();
    } 

    public static function update($id, $description, $end, $pause, $units) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare(" UPDATE {$table} SET 
                                    description = :description,
                                    end = :end,
                                    pause = :pause,
                                    units = :units
                                    WHERE id = :id");
        $statement->bindParam(":id", $id);
        $statement->bindParam(":description", $description);
        $statement->bindParam(":end", $end);
        $statement->bindParam(":pause", $pause);
        $statement->bindParam(":units", $units);
        $statement->execute();
    }

    public static function get_psp_tasks($idPSP) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare(" SELECT pt.id,pt.description
                                    FROM {$table} AS pt
                                    INNER JOIN psps AS p ON pt.idPSP=p.id
                                    WHERE p.id = :idPSP");
        $statement->bindParam(":idPSP", $idPSP, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }

/*

    public static function get_user_tasks($idUser, $idProject) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare(" SELECT t.id,t.name
                                    FROM {$table} AS t
                                    INNER JOIN tasksusersprojects AS tup ON t.id=tup.idTask
                                    WHERE tup.idUser = :idUser AND t.idProject = :idProject");
        $statement->bindParam(":idProject", $idProject, PDO::PARAM_INT);
        $statement->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }
*/






    
}