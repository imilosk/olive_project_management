<?php 

require_once __DIR__ . '/../../models/PSPTask.php';
require_once __DIR__ . '/TaskUserProjectController.php';

class PSPTaskController {

    public static function show($id) {
        $psptask = PSPTask::get($id);
        Flight::json($psptask);
    }

    public static function store() {
        $idPhase = $_POST["idPhase"];
        $idPSP = TaskUserProjectController::get_PSP($_POST["idUser"], $_POST["idTask"]);
        $start = $_POST["start"];
        $end = $_POST["end"];
        $pause = $_POST["pause"];
        $description = $_POST["description"];
        $units = $_POST["units"];
        $estimatedtime = $_POST["estimatedtime"];
        $estimatedunits = $_POST["estimatedunits"];
        $response = PSPTask::insert($idPhase, $idPSP, $start, $end, $pause, $description, $units, $estimatedtime, $estimatedunits);
        Flight::json($response);
    }

    public static function update($id) {
        $id = (int) $id;
        $description = $_POST["description"];
        $end = $_POST["end"];
        $pause = $_POST["pause"];
        $units = $_POST["units"];
        $response = PSPTask::update($id, $description, $end, $pause, $units);
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
