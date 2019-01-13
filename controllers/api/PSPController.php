<?php 

require_once __DIR__ . '/../../models/PSP.php';

class PSPController {

    public static function show($id) {
        $psp = Psp::get($id);
        Flight::json($psp);
    }

    public static function store() {
        $response = PSP::insert();
        return (int) $response;
    }

    public static function update($idPSP) {
        $prog_lang = $_POST["programing_language"];
        $response = PSP::update($idPSP, $prog_lang);
        Flight::json($response);
    }


    public static function delete($id) {
        $response = PSP::delete($id);
        Flight::json($response);
        echo "true";
    }

    public static function get_data($idUser, $idTask) {
        $data = PSP::get_psp_data($idUser, $idTask);
        Flight::json($data);
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