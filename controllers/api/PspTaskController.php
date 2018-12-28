<?php 

require_once __DIR__ . '/../../models/PSPTask.php';

class PspTaskController {

    public static function get_psp_tasks_psp($idPsp) {
        $psp_tasks = PspTask::get_psp_psp_tasks($idPsp);
        Flight::json($psp_tasks);
    }
/*

    public static function get_psp_tasks_phase($idUser) {
        $organisations = OrganisationUser::get_user_organisations($idUser);
        Flight::json($organisations);
    }

    public static function store() {
        $idOrganisation = $_POST["idOrganisation"];
        $idUser = $_POST["idUser"];
        $response = OrganisationUser::insert($idOrganisation, $idUser);
        Flight::json($response);
    }

    public static function delete($idOrganisation, $idUser) {
        $response = OrganisationUser::delete($idOrganisation, $idUser);
        Flight::json($response);
    }
*/
}