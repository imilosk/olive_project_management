<?php

require_once __DIR__ . '/../../models/User.php';

class UserController {

    public static function index() {
        $idOrganisation = (int) Flight::request()->query['idOrganisation'];
        if ($idOrganisation == "")
            $users = User::get_all();
        else
            $users = User::get_all_users_in_organisation($idOrganisation);
        Flight::json($users);
        
    }

    /*
    public static function show($id) {
        $user = User::get($id);
        Flight::json($user);
    }

    
    public static function store() {
        
        echo "true";
    }

    public static function update($id) {
       
        echo "true";
    }
    
    public static function delete($id) {
        
        echo "true";
    }
    */

}