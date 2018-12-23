<?php 

require_once __DIR__ . '/../../models/Project.php';
require_once __DIR__ . '/../../models/OrganisationUser.php';

class OrganisationUserController {

    public static function get_user_organisations($idOrganisation) {
        $organisations = OrganisationUser::get_user_organisations($idOrganisation);
        Flight::json($organisations);
    }

    public static function store($idOrganisation, $idUser) {
        $response = OrganisationUser::add_user_to_organisation($idOrganisation, $idUser);
        Flight::json($response);
    }

    public static function delete($idOrganisation, $idUser) {
        $response = OrganisationUser::remove_user_from_organisation($idOrganisation, $idUser);
        Flight::json($response);
    }

}