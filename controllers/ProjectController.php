<?php 

require_once __DIR__ . '/../models/Project.php';
require_once __DIR__ . '/../models/Organisation.php';

class ProjectController {

    public static function index() {
        $projects = Project::get_all();
        render_view('pages/projects', ['projects' => $projects]);
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

}
