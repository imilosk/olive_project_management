<?php

require_once __DIR__ . '/../../models/User.php';

class UserController {

    public static function index() {
        $idOrganisation = (int) Flight::request()->query['idOrganisation'];
        $idProject = (int) Flight::request()->query['idProject'];
        $idTask = (int) Flight::request()->query['idTask'];
        if ($idOrganisation == "" && $idProject == "" && $idTask == "")
            $users = User::get_all();
        elseif ($idProject != "")
            $users = User::get_all_users_in_project($idProject);
        elseif ($idOrganisation != "") 
            $users = User::get_all_users_in_organisation($idOrganisation);
        else
            $users = User::get_all_users_in_task($idTask);
        Flight::json($users);
    }

    public static function getUserInfo() {
        $email = Flight::request()->query['userEmail'];
        $id = Flight::request()->query['userId'];

        if ($email != "")
            $info = User::getByEmail($email);
        else if ($email == "" && $id != "")
            $info = User::get($id);
        
        Flight::json($info);
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