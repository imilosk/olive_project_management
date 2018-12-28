<?php 

require_once __DIR__ . '/../../models/PSP.php';

class PSPController {

    public static function show($id) {
        $psp = Psp::get($id);
        Flight::json($psp);
    }

    public static function store() {
        $response = PSP::insert();
        Flight::json($response);
        echo "true";
    }

    public static function delete($id) {
        $response = PSP::delete($id);
        Flight::json($response);
        echo "true";
    }

/*
    public static function index() {
        $idProject = (int) Flight::request()->query['idProject'];
        $idUser = (int) Flight::request()->query['idUser'];
        if ($idUser == "") 
            $projects = Task::get_project_tasks($idProject);
        else
            $projects = Task::get_user_tasks($idUser, $idProject);
        Flight::json($projects);
    }
*/


}