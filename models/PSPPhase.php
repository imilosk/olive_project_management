<?php

require_once __DIR__ . '/../settings/DBInit.php';

class PspPhase {

    const TABLE_NAME = 'psp_phases';


    public static function get_all() {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT name FROM {$table}");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

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
    
}