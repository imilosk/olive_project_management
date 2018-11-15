<?php

// include all files in controllers/api
require_once __DIR__ . '/../controllers/api/UserController.php';

// return all users
Flight::route('/api/users', function() {
    UserController::index();
});	

// return one user identified by $id
Flight::route('/api/user/@id', function($id) {
    UserController::show($id);
});	

// add user
Flight::route('POST /api/user', function() {
    UserController::store();
});
