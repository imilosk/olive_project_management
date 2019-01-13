<?php 

require_once __DIR__ . '/../../models/PSPTask.php';
require_once __DIR__ . '/TaskUserProjectController.php';
require_once __DIR__ . '/UserPSPDataController.php';

class PSPTaskController {

    public static function show($id) {
        $psptask = PSPTask::get($id);
        Flight::json($psptask);
    }

    public static function store() {
        $idPhase = $_POST["idPhase"];
        $idUser=$_POST["idUser"];
        $idPSP = TaskUserProjectController::get_PSP($idUser, $_POST["idTask"]);
        $start = $_POST["start"];
        $end = $_POST["end"];
        $pause = $_POST["pause"];
        $description = $_POST["description"];
        $units = $_POST["units"];
        $estimatedtime = $_POST["estimatedtime"];
        $estimatedunits = $_POST["estimatedunits"];
        $response = PSPTask::insert($idPhase, $idPSP, $start, $end, $pause, $description, $units, $estimatedtime, $estimatedunits);
        UserPSPDataController::update_user_psps($idUser);
        Flight::json($response);
    }

    public static function update($id) {
        $id = (int) $id;
        $idPhase = $_POST["idPhase"];
        //$idUser=$_POST["idUser"];
        //$idPSP = TaskUserProjectController::get_PSP($idUser, $_POST["idTask"]);
        $start = $_POST["start"];
        $end = $_POST["end"];
        $pause = $_POST["pause"];
        $description = $_POST["description"];
        $units = $_POST["units"];
        $estimatedtime = $_POST["estimatedtime"];
        $estimatedunits = $_POST["estimatedunits"];
        $response = PSPTask::update($id, $idPhase, $start, $end, $pause, $description, $units, $estimatedtime, $estimatedunits);
        //UserPSPDataController::update_user_psps($idUser);
        echo "true";
    }

    public static function delete($id) {
        $response = PSPTask::delete($id);
        Flight::json($response);
    }

     public static function get_psp_tasks($idUser,$idTask) {
        $psp_tasks = PSPTask::get_psp_tasks($idUser,$idTask);
        Flight::json($psp_tasks);
    }

/*
    public static function get_psp_tasks_phase($idUser) {
        $organisations = OrganisationUser::get_user_organisations($idUser);
        Flight::json($organisations);
    }
*/

}
