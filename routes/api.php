<?php

// include all files in controllers/api
require_once __DIR__ . '/../controllers/api/UserController.php';
require_once __DIR__ . '/../controllers/api/OrganisationController.php';
require_once __DIR__ . '/../controllers/api/OrganisationUserController.php';
require_once __DIR__ . '/../controllers/api/ProjectController.php';
require_once __DIR__ . '/../controllers/api/UserProjectController.php';
require_once __DIR__ . '/../controllers/api/TaskController.php';
require_once __DIR__ . '/../controllers/api/TaskUserProjectController.php';


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

// get all users or get all users in an organisation or get all users in a project or get all users in a task 
Flight::route('GET /api/users', function() {
	UserController::index();
});

// add a user to an organisation
Flight::route('POST /api/organisationsusers', function() {
	OrganisationUserController::store();
});

// remove a user from an organisation
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

// update project
Flight::route('POST /api/project/@id', function($id) {
    ProjectController::update($id);
});

// remove project
Flight::route('DELETE /api/project/@id', function($id) {
	ProjectController::delete($id);
});

// get all projects of an organisation or get all projects of an user
Flight::route('GET /api/projects', function() {
	ProjectController::index();
});

// add a user to project
Flight::route('POST /api/projectsusers', function() {
	UserProjectController::store();
});

// remove a user from a project
Flight::route('DELETE /api/projectsusers/@idProject/@idUser', function($idProject, $idUser) {
	UserProjectController::delete($idProject, $idUser);
});

// get task
Flight::route('GET /api/task/@id', function($id) {
	TaskController::show($id);
});

// add task
Flight::route('POST /api/task', function() {
    TaskController::store();
});

// update task
Flight::route('POST /api/task/@id', function($id) {
    TaskController::update($id);
});

// remove task
Flight::route('DELETE /api/task/@id', function($id) {
	TaskController::delete($id);
});

// add a user to a task
Flight::route('POST /api/tasksusers', function() {
	TaskUserProjectController::store();
});

// remove a user from a task
Flight::route('DELETE /api/tasksusers/@idUser/@idTask', function($idUser, $idTask) {
	TaskUserProjectController::delete($idUser, $idTask);
});

// get all tasks of a project or get all tasks of an user
Flight::route('GET /api/tasks', function() {
	TaskController::index();
});

// get all tasks of a project or get all tasks of an user
Flight::route('GET /api/userorganisationsprojects', function() {
	$idUser = Flight::request()->query['idUser'];
	OrganisationController::get_user_organisations_and_projects($idUser);
});
