<?php

require_once __DIR__ . '/../settings/DBInit.php';

class PSPError {

    const TABLE_NAME = 'psp_errors';



    public static function get($id) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare(" SELECT id 
                                    FROM {$table} 
                                    WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch();
    }

    public static function insert($idCategory, $phaseEntry, $phaseFinish, $idPSP, $resolve_time, $num_fixed_errors, $description) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare(" INSERT INTO {$table} (idCategory, phaseEntry, phaseFinish, idPSP, resolve_time, num_fixed_errors, description)
                                    VALUES (:idCategory, :phaseEntry, :phaseFinish, :idPSP, :resolve_time, :num_fixed_errors, :description)");
        $statement->bindParam(":idCategory", $idCategory);
        $statement->bindParam(":phaseEntry", $phaseEntry);
        $statement->bindParam(":phaseFinish", $phaseFinish);
        $statement->bindParam(":idPSP", $idPSP);
        $statement->bindParam(":resolve_time", $resolve_time);
        $statement->bindParam(":num_fixed_errors", $num_fixed_errors);
        $statement->bindParam(":description", $description);
        $statement->execute();
    }

    public static function update($id, $idCategory, $phaseFinish, $resolve_time, $num_fixed_errors, $description) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare(" UPDATE {$table} SET 
                                    description = :description,
                                    idCategory = :idCategory,
                                    phaseFinish = :phaseFinish,
                                    resolve_time = :resolve_time,
                                    num_fixed_errors = :num_fixed_errors
                                    WHERE id = :id");
        $statement->bindParam(":id", $id);
        $statement->bindParam(":description", $description);
        $statement->bindParam(":idCategory", $idCategory);
        $statement->bindParam(":phaseFinish", $phaseFinish);
        $statement->bindParam(":resolve_time", $resolve_time);
        $statement->bindParam(":num_fixed_errors", $num_fixed_errors);
        $statement->execute();
    }

    public static function delete($id) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("DELETE FROM {$table} WHERE id = :id");
        $statement->bindParam(":id", $id);
        $statement->execute();
    } 

    public static function get_psp_errors($idPSP) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare(" SELECT pe.id,pe.description
                                    FROM {$table} AS pe
                                    INNER JOIN psps AS p ON pe.idPSP=p.id
                                    WHERE p.id = :idPSP");
        $statement->bindParam(":idPSP", $idPSP, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }
    
}