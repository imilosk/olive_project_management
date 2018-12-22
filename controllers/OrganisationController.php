<?php 

require_once __DIR__ . '/../models/Project.php';
require_once __DIR__ . '/../models/Organisation.php';

class OrganisationController {

    public static function index() {
        $organisations = Organisation::get_all();
        render_view('pages/organisations', ['organisations' => $organisations]);
    }

    public static function create() {
        $organisation = Organisation::get_all();
        if(isset($_POST['submitButton'])){
            Project::insert($_POST['name'], $_POST['description'], $_POST['organisation']);
            Flight::redirect("/projects");
            //render_view("pages/projects");
        } else {
            render_view("pages/create_project", ['organisations' => $organisation]);
        }
    }
    public static function delete($id) {
            Project::delete($id);
            Flight::redirect("/projects");
            //render_view("pages/projects");
    }

    

}
