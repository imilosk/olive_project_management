<?php 

class HomeController {

    public static function index() {
        render_view('home', ['name' => 'kraco']);
    }

}
