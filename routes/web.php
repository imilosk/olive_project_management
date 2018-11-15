<?php
require_once __DIR__ . '/../controllers/HomeController.php';

Flight::route('/', function() {
    HomeController::index();
});

