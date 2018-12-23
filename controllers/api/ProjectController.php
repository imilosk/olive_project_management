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
        $response = Project::insert($name, $description, $idOrganisation);
        Flight::json($response);
    }

    public static function delete($id) {
        $response = Project::delete($id);
        Flight::json($response);
    }

    public static function update($id) {
        $id = (int) $id;
        $name = $_POST["name"];
        $description = $_POST["description"];
        $response = Project::update($id, $name, $description);
        echo "true";
    }


    public static function index() {
        $idOrganisation = (int) Flight::request()->query['idOrganisation'];
        $projects = Project::get_organisation_projects($idOrganisation);
        Flight::json($projects);
    }


}