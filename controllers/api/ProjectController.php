<?php 

require_once __DIR__ . '/../../models/Project.php';

class ProjectController {

/*
    public static function get_organization_projects($idProject) {
        $projects = OrganisationUser::get_user_organisations($idProject);
        Flight::json($project);
    }
*/

    public static function show($id) {
        $project = Project::get($id);
        Flight::json($project);
    }

    public static function store() {
        $idOrganisation = $_POST["idOrganisation"];
        $name = $_POST["name"];
        $description = $_POST["description"];
        $response = Project::insert($idOrganisation, $name, $description);
        Flight::json($response);
    }

    public static function delete($idOrganisation, $idUser) {
        $response = OrganisationUser::delete($idOrganisation, $idUser);
        Flight::json($response);
    }



}