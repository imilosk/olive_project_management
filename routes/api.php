<?php

// include all files in controllers/api
require_once __DIR__ . '/../controllers/api/UserController.php';
require_once __DIR__ . '/../controllers/api/OrganisationController.php';
require_once __DIR__ . '/../controllers/api/OrganisationUserController.php';
require_once __DIR__ . '/../controllers/api/ProjectController.php';


// add organisation
Flight::route('POST /api/organisation', function() {
    OrganisationController::store();
});

// update organisation info
Flight::route('POST /api/organisation/@id', function($id) {
    OrganisationController::update($id);
});

// delete organisation
Flight::route('DELETE /api/organisation/@id', function($id) {
    OrganisationController::delete($id);
});

// get all organisations of a user
Flight::route('GET /api/organisations', function() {
	$idUser = Flight::request()->query['idUser'];
	OrganisationUserController::get_user_organisations($idUser);
});

// get all users or get all users in an organisation
Flight::route('GET /api/users', function() {
	UserController::index();
});

// add a user to an organisation
Flight::route('POST /api/organisationsusers', function() {
	OrganisationUserController::store();
});

// remove a user to an organisation
Flight::route('DELETE /api/organisationsusers/@idOrganisation/@idUser', function($idOrganisation, $idUser) {
	OrganisationUserController::delete($idOrganisation, $idUser);
});

// get project
Flight::route('GET /api/project/@id', function($id) {
	ProjectController::show($id);
});

// add project
Flight::route('POST /api/project', function() {
    ProjectController::store();
});
