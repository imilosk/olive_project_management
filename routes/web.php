<?php
require __DIR__ . '/../controllers/HomeController.php';

Flight::route('/', function() {
    HomeController::index();
});
