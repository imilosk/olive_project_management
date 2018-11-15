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

    public static function update($id) {
        $username = $_POST['username'];
        $rating = $_POST['rating'];
        User::update($id, $username, $rating);
        echo "true";
    }

    public static function delete($id) {
        User::delete($id);
        echo "true";
    }

}