<?php 

require_once __DIR__ . '/../../models/Project.php';
require_once __DIR__ . '/../../models/OrganisationUser.php';

class OrganisationUserController {

    public static function get_user_organisations($id) {
        $org = OrganisationUser::getUserOrganisations($id);
        Flight::json($org);
    }
}