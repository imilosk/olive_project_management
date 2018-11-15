<?php

require_once __DIR__ . '/../../models/User.php';

class UserController {

    public static function index() {
        $users = User::get_all();
        Flight::json($users);
    }

    public static function show($id) {
        $user = User::get($id);
        Flight::json($user);
    }

    public static function store() {
        $username = $_POST["username"];
        User::insert($username);
        echo "true";
    }

}