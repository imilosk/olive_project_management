<?php 

require_once __DIR__ . '/../../models/Project.php';
require_once __DIR__ . '/../../models/UserProject.php';

class UserProjectController {

    public static function store() {
        $idProject = $_POST["idProject"];
        $idUser = $_POST["idUser"];
        $response = UserProject::insert($idProject, $idUser);
        Flight::json($response);
    }

    public static function delete($idProject, $idUser) {
        $response = UserProject::delete($idProject, $idUser);
        Flight::json($response);
    }

}