<?php 

require_once __DIR__ . '/../../models/Project.php';
require_once __DIR__ . '/../../models/OrganisationUser.php';

class OrganisationUserController {

    public static function show($id) {
        $user = User::get($id);
        Flight::json($user);
    }

    public static function getUserOrganisations($id) {
        $org = OrganisationUser::getUserOrganisations($id);
        Flight::json($org);
    }
}