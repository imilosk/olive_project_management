<?php

require_once __DIR__ . '/../settings/DBInit.php';
require_once __DIR__ . '/Project.php';

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
    

    public static function insert($name, $description, $idLeader) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("INSERT INTO {$table} (name,description, idLeader)
            VALUES (:name,:description, :idLeader)");
        $statement->bindParam(":name", $name);
        $statement->bindParam(":description", $description);
        $statement->bindParam(":idLeader", $idLeader);
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
        // get organisations info of the user
        $statement = $db->prepare("SELECT o.id AS idOrganisation, o.name AS orgName, o.description AS orgDesc, o.idLeader AS orgLeaderId
                                    FROM {$table} AS o 
                                    INNER JOIN organisationsusers AS ou ON ou.idOrganisation = o.id 
                                    WHERE ou.idUser =  :idUser 
                                ");

    
        $statement->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        $statement->execute(); 
        $result = $statement->fetchAll();
        
        // get project info of the organisations
        $i = 0;
        foreach ($result as $org) {
            $idOrg = $org["idOrganisation"];
            $projects = Project::get_user_projects($idUser,$idOrg);
            $j = 0;
            foreach ($projects as $pro){
                $result[$i][$j]["idProject"] = (int) $pro["id"];
                $result[$i][$j]["pName"] = $pro["name"];
                $result[$i][$j]["pDesc"] = $pro["description"];
                $result[$i][$j]["idLeader"] = $pro["idLeader"];
                $j++;
            }
            $i++;
        }
        return $result;

    }
}


