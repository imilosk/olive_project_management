<?php

require_once __DIR__ . '/../settings/DBInit.php';

class Organisation {

    const TABLE_NAME = 'organisations';
    /*
    public static function get_all() {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT * FROM {$table}");
        $statement->execute();
        return $statement->fetchAll();
    }
    */
    
    public static function get($id) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT id,name,description FROM {$table} WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch();
    }
    

    public static function insert($name, $description) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("INSERT INTO {$table} (name,description)
            VALUES (:name,:description)");
        $statement->bindParam(":name", $name);
        $statement->bindParam(":description", $description);
        $statement->execute();
        return $db->lastInsertId();
    }

    public static function update($id, $name, $description) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare(" UPDATE {$table} SET 
                                    name = :name, 
                                    description = :description
                                    WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->bindParam(":name", $name);
        $statement->bindParam(":description", $description);
        $statement->execute();
        return "true";
    }

    public static function delete($id) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("DELETE FROM {$table}
                                   WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        return "true";
    }

    public static function get_user_organisations_and_projects($idUser) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT o.id AS idOrganisation,
                                          p.id AS idProject,
                                          p.name AS pName,
                                          p.description AS pDesc
                                   FROM {$table} AS o
                                   INNER JOIN projects AS p ON p.idOrganisation = o.id
                                   INNER JOIN userprojects AS up ON up.idProject = p.id
                                   WHERE up.idUser = :idUser
                                ");
        $statement->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        $statement->execute(); 
        $result = $statement->fetchAll(PDO::FETCH_GROUP);
        
        // add organisation name and description
        $ids = array_keys($result);
        foreach ($ids as $value) {
            $org = self::get($value);
            $result[$value]["idOrganisation"] = (int) $org["id"];
            $result[$value]["orgName"] = $org["name"];
            $result[$value]["orgDesc"] = $org["description"];
        }
        $result = array_values($result);
        return $result;
    }
    
}
