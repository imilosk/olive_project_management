<?php 

require_once __DIR__ . '/../models/User.php';

class HomeController {

    public static function index() {
        $users = User::get_all();
        render_view('pages/home', ['users' => $users]);
    }

}
