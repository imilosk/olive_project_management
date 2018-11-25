<?php
require_once __DIR__ . '/../controllers/HomeController.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/TimeNotesController.php';
require_once __DIR__ . '/../controllers/MistakesController.php';

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

// Pages
Flight::route('/timeNotes', function() {
    TimeNotesController::index();
});
// Pages
Flight::route('/mistakes', function() {
    MistakesController::index();
});

