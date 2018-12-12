<?php
require_once __DIR__ . '/../controllers/HomeController.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/TimeNotesController.php';
require_once __DIR__ . '/../controllers/MistakesController.php';
require_once __DIR__ . '/../controllers/ProjectController.php';

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

// PSP
Flight::route('/timeNotes', function() {
    TimeNotesController::index();
});

Flight::route('/mistakes', function() {
    MistakesController::index();
});

    // Project
    Flight::route('/projects', function() {
    ProjectController::index();
    });
    // Create_project
    Flight::route('/create_project', function() {
    ProjectController::create();
    });
    Flight::route('/projects/delete/@id', function($id) {
    ProjectController::delete($id);
    });