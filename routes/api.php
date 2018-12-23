<?php

// include all files in controllers/api
require_once __DIR__ . '/../controllers/api/UserController.php';
require_once __DIR__ . '/../controllers/api/OrganisationUserController.php';

// return all users
Flight::route('GET /api/users', function() {            
    UserController::index();
});

// return one user identified by $id
Flight::route('GET /api/user/@id', function($id) {
    UserController::show($id);
});

// add user
Flight::route('POST /api/user', function() {
    UserController::store();
});

// update user info
Flight::route('POST /api/user/@id', function($id) {
    UserController::update($id);
});

// delete user
Flight::route('DELETE /api/user/@id', function($id) {
    UserController::delete($id);
});

// get all organisations of a user
Flight::route('GET /api/organisations', function(){
	#$id = Flight::request()->query['userId'];
	OrganisationUserController::getUserOrganisations(3);
});
