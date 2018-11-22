<?php
require_once __DIR__ . '/../controllers/HomeController.php';
require_once __DIR__ . '/../controllers/AuthController.php';

// Auth
Flight::route('/register', function() {
    AuthController::register();
});

Flight::route('/login', function() {
    AuthController::login();
});

Flight::route('/logout', function() {
    AuthController::logout();
});

// Pages
Flight::route('/', function() {
    HomeController::index();
});


