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
        Organisation::insert($name, $description);
        echo "true";
    }

    public static function update($id) {
        $id = (int) $id;
        $name = $_POST["name"];
        $description = $_POST["description"];
        Organisation::update($id, $name, $description);
        echo "true";
    }
    
    public static function delete($id) {
        Organisation::delete($id);
        echo "true";
    }

}