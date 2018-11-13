<?php
require __DIR__ . '/../controllers/HomeController.php';

Flight::route('/', function() {
    HomeController::index();
});	

Flight::route('/hello/@name', function($name) {
    render_view('first', ['name' => $name]);
});	

Flight::route('/hello/*', function() {
    echo 'hello all';
});	
