<?php 

require_once __DIR__ . '/../../models/Task.php';
require_once __DIR__ . '/../../models/TaskUserProject.php';

class TaskUserProjectController {

    public static function store() {
        $idTask = $_POST["idTask"];
        $idUser = $_POST["idUser"];
        $idPSP = $_POST["idPSP"];
        $response = TaskUserProject::insert($idUser, $idTask, $idPSP);
        Flight::json($response);
    }

    public static function delete($idUser, $idTask) {
        $response = TaskUserProject::delete($idUser, $idTask);
        Flight::json($response);
    }

}