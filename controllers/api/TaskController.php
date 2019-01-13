<?php 

require_once __DIR__ . '/../../models/Task.php';

class TaskController {

    public static function show($id) {
        $task = Task::getInfo($id);
        Flight::json($task);
    }

    public static function store() {
        $name = $_POST["name"];
        $idProject = $_POST["idProject"];
        $status = $_POST["status"];
        $response = Task::insert($name, $idProject, $status);
        Flight::json($response);
    }

    public static function delete($id) {
        $response = Task::delete($id);
        Flight::json($response);
    }

    public static function update($id) {
        $id = (int) $id;
        $name = $_POST["name"];
        $desc = $_POST["description"];

        if ($desc != "")
            Task::updateDesc($id, $desc);
        else if ($name != "")
            $response = Task::update($id, $name);
    }

    public static function changeStatus(){
        $taskId = (int)$_POST["taskId"];
        $status = (int)$_POST["status"];
        Task::changeStatus($taskId, $status);
    }

    public static function index() {
        $idProject = (int) Flight::request()->query['idProject'];
        $idUser = (int) Flight::request()->query['idUser'];
        $idTask = (int) Flight::request()->query['idTask'];

        if ($idProject != "" && $idTask != "")
            $result = Task::get_available_users($idProject, $idTask);
        else if ($idUser == "") 
            $result = Task::get_project_tasks($idProject);
        else
            $result = Task::get_user_tasks($idUser, $idProject);
        Flight::json($result);
    }

    public static function get_project_tasks_and_users($idUser, $idProject) {
        $tasks = Task::get_project_tasks_status($idUser, $idProject);
        Flight::json($tasks);
    }


}