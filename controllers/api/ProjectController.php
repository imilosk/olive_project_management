<?php 

require_once __DIR__ . '/../../models/Project.php';

class ProjectController {

    public static function show($id) {
        $project = Project::get($id);
        Flight::json($project);
    }

    public static function store() {
        $idOrganisation = $_POST["idOrganisation"];
        $name = $_POST["name"];
        $description = $_POST["description"];
        $idLeader = (int) $_POST["idLeader"];
        $response = Project::insert($name, $description, $idOrganisation, $idLeader);
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
        $idUser = (int) Flight::request()->query['idUser'];
        $idProject = (int) Flight::request()->query['idProject'];

        if ($idProject != "")
            $result = Project::get_users_in_project($idProject);
        else if ($idUser == "" && $idOrganisation != "")
            $result = Project::get_organisation_projects($idOrganisation);
        else
            $result = Project::get_user_projects($idUser, $idOrganisation);

        Flight::json($result);
    }


}