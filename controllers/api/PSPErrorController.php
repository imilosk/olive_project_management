<?php 

require_once __DIR__ . '/../../models/PSPError.php';

class PSPErrorController {

    public static function show($id) {
        $psptask = PspError::get($id);
        Flight::json($psptask);
    }

    public static function store() {
        $idCategory = $_POST["idCategory"];
        $phaseEntry = $_POST["phaseEntry"];
        $phaseFinish = 8;
        $idPSP = $_POST["idPSP"];
        $resolve_time = 0;
        $num_fixed_errors = 0;
        $description = $_POST["description"];
        $response = PspError::insert($idCategory, $phaseEntry, $phaseFinish, $idPSP, $resolve_time, $num_fixed_errors, $description);
        Flight::json($response);
    }

    public static function update($id) {
        $id = (int) $id;
        $idCategory = $_POST["idCategory"];
        $description = $_POST["description"];
        $phaseFinish = $_POST["phaseFinish"];
        $resolve_time = $_POST["resolve_time"];
        $num_fixed_errors = $_POST["num_fixed_errors"];
        $response = PspError::update($id, $idCategory, $phaseFinish, $resolve_time, $num_fixed_errors, $description);
        echo "true";
    }

    public static function delete($id) {
        $response = PspError::delete($id);
        Flight::json($response);
    }

    public static function get_psp_errors($idUser,$idTask) {
        $psp_errors = PspError::get_psp_errors($idUser,$idTask);
        Flight::json($psp_errors);
    }

/*
    public static function get_psp_tasks_phase($idUser) {
        $organisations = PspError::get_user_organisations($idUser);
        Flight::json($organisations);
    }
*/

}
