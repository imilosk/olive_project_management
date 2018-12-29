<?php

require_once __DIR__ . '/../../models/Organisation.php';

class OrganisationController {

    /*
    public static function index() {
        $organisation = Organisation::get_all();
        Flight::json($organisation);
    }
    */

    /*
    public static function show($id) {
        $organisatio = Organisation::get($id);
        Flight::json($organisatio);
    }
    */

    public static function store() {
        $name = $_POST["name"];
        $description = $_POST["description"];
        echo Organisation::insert($name, $description);
    }

    public static function update($id) {
        $id = (int) $id;
        $name = $_POST["name"];
        $description = $_POST["description"];
        Organisation::update($id, $name, $description);
    }
    
    public static function delete($id) {
        Organisation::delete($id);
    }

    public static function get_user_organisations_and_projects($idUser) {
        $organisations = Organisation::get_user_organisations_and_projects($idUser);
        //$temp = array_keys($organisations);
        //return;
        Flight::json($organisations);
        //Flight::json($temp);
    }

}