<?php

require_once __DIR__ . '/../settings/DBInit.php';
require_once __DIR__ . '/TaskUserProject.php';
require_once __DIR__ . '/User.php';

class Task {

    const TABLE_NAME = 'tasks';

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
        $statement = $db->prepare(" SELECT id, name, description, idTask_status 
                                    FROM {$table} 
                                    WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch();
    }

    public static function getInfo($id) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare(" SELECT id, name, description, idTask_status 
                                    FROM {$table} 
                                    WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch();

        $usersInTask = TaskUserProject::get_task_users($id);
        
        /*
        $users = [];
        foreach ($usersInTask as $userId) {
            $users[$userId] = User::get($userId)["email"];
        }  */

        $result["users"] = $usersInTask;

        return $result;
    }

    public static function insert($name, $idProject, $status) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare(" INSERT INTO {$table} (name, idProject, idTask_status)
                                    VALUES (:name,:idProject,:status)");
        $statement->bindParam(":name", $name);
        $statement->bindParam(":idProject", $idProject);
        $statement->bindParam(":status", $status);
        $statement->execute();
    }

    public static function update($id, $name) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare(" UPDATE {$table} SET 
                                    name = :name
                                    WHERE id = :id");
        $statement->bindParam(":name", $name);
        $statement->bindParam(":id", $id);
        $statement->execute();
    }

     public static function updateDesc($id, $description) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare(" UPDATE {$table} SET 
                                    description = :description
                                    WHERE id = :id");
        $statement->bindParam(":description", $description);
        $statement->bindParam(":id", $id);
        $statement->execute();
     }

    public static function delete($id) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("DELETE FROM {$table} WHERE id = :id");
        $statement->bindParam(":id", $id);
        $statement->execute();
    }

    public static function changeStatus($taskId, $status) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("UPDATE {$table} SET idTask_status = :status WHERE id = :taskId");
        $statement->bindParam(":status", $status);
        $statement->bindParam(":taskId", $taskId);
        $statement->execute();
    } 

    public static function get_project_tasks($idProject) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare(" SELECT t.id,t.name
                                    FROM {$table} AS t
                                    INNER JOIN projects AS p ON t.idProject=p.id
                                    WHERE p.id = :idProject");
        $statement->bindParam(":idProject", $idProject, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }

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

    public static function get_available_users($idProject, $idTask){
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT up.idUser, u.email
                                    FROM Users u 
                                    INNER JOIN userprojects up ON up.idUser = u.id
                                    WHERE up.idProject = :idProject AND up.idUser NOT IN (SELECT idUser FROM tasksusersprojects WHERE idTask = :idTask)");
        $statement->bindParam(":idProject", $idProject, PDO::PARAM_INT);
        $statement->bindParam(":idTask", $idTask, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }

    
    public static function get_project_tasks_status($idUser, $idProject) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        // get tasks of the project
        $statement = $db->prepare("SELECT t.id AS idTask, t.name AS taskName, s.name AS 'status'
                                    FROM {$table} AS t 
                                    RIGHT JOIN task_status AS s ON t.idTask_status  = s.id 
                                    WHERE t.idProject = :idProject 
                                ");

        $statement->bindParam(":idProject", $idProject, PDO::PARAM_INT);
        $statement->execute(); 
        $result = $statement->fetchAll();
        $results=[];
        
        $i = 0;
        foreach ($result as $task) {
            $temp = $task;
            $status = str_replace(" ", "_", $task["status"]);

            unset($task["status"]);
            $users = TaskUserProject::get_task_users($task["idTask"]);

            $task["users"]=$users;
            $temp_users=[];

            foreach($users as $user)
                $temp_user[]=$user["idUser"];
            
            $task["access"]=in_array($idUser, $temp_user);
            $results[$status][]= $task;
            $i++;
        }
        return $results;
    }
}