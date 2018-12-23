<?php 

require_once __DIR__ . '/../../models/Project.php';
require_once __DIR__ . '/../../models/OrganisationUser.php';

class OrganisationUserController {

    public static function get_user_organisations($idUser) {
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

}