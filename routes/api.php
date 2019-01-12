<?php

// include all files in controllers/api
require_once __DIR__ . '/../controllers/api/UserController.php';
require_once __DIR__ . '/../controllers/api/OrganisationController.php';
require_once __DIR__ . '/../controllers/api/OrganisationUserController.php';
require_once __DIR__ . '/../controllers/api/ProjectController.php';
require_once __DIR__ . '/../controllers/api/UserProjectController.php';
require_once __DIR__ . '/../controllers/api/TaskController.php';
require_once __DIR__ . '/../controllers/api/TaskUserProjectController.php';
require_once __DIR__ . '/../controllers/api/PSPController.php';
require_once __DIR__ . '/../controllers/api/PSPTaskController.php';
require_once __DIR__ . '/../controllers/api/PSPErrorController.php';
require_once __DIR__ . '/../controllers/api/PSPErrorCategoryController.php';
require_once __DIR__ . '/../controllers/api/PSPPhaseController.php';
require_once __DIR__ . '/../controllers/api/UserPSPDataController.php';

// get user email using id or get user id using email
Flight::route('GET /api/user', function() {
	UserController::getUserInfo();
});

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

//change task's status
Flight::route('POST /api/taskstatus', function() {
    TaskController::changeStatus();
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

// get all tasks of a project or get all tasks of an user or get available users for a task in a project
Flight::route('GET /api/tasks', function() {
	TaskController::index();
});

// get all tasks of a project or get all tasks of an user
Flight::route('GET /api/userorganisationsprojects', function() {
	$idUser = Flight::request()->query['idUser'];
	OrganisationController::get_user_organisations_and_projects($idUser);
});

// get PSP
Flight::route('GET /api/psp/@id', function($id) {
	PSPController::show($id);
});

// get PSP
Flight::route('GET /api/pspdata/@idUser/@idTask', function($idUser, $idTask) {
	PSPController::get_data($idUser, $idTask);
});

// add PSP
Flight::route('POST /api/psp', function() {
    PSPController::store();
});

// remove task
Flight::route('DELETE /api/psp/@id', function($id) {
	PSPController::delete($id);
});

// get psp task
Flight::route('GET /api/psptask/@id', function($id) {
	PSPTaskController::show($id);
});

// add psp task
Flight::route('POST /api/psptask', function() {
    PSPTaskController::store();
});

// update psp task
Flight::route('POST /api/psptask/@id', function($id) {
    PSPTaskController::update($id);
});

// remove psp task
Flight::route('DELETE /api/psptask/@id', function($id) {
	PSPTaskController::delete($id);
});

// get all tasks of a psp
Flight::route('GET /api/psptasks/@idUser/@idTask', function($idUser,$idTask) {
	PSPTaskController::get_psp_tasks($idUser,$idTask);
});

// get psp error
Flight::route('GET /api/psperror/@id', function($id) {
	PSPErrorController::show($id);
});

// add psp error
Flight::route('POST /api/psperror', function() {
    PSPErrorController::store();
});

// update psp error
Flight::route('POST /api/psperror/@id', function($id) {
    PSPErrorController::update($id);
});

// remove psp error
Flight::route('DELETE /api/psperror/@id', function($id) {
	PSPErrorController::delete($id);
});

// get all errors of a psp
Flight::route('GET /api/psperrors/@idUser/@idTask', function($idUser,$idTask) {
	PSPErrorController::get_psp_errors($idUser,$idTask);
});

// get all error categories
Flight::route('GET /api/psperrorcategories', function() {
	PSPErrorCategorieController::index();
});

// get specific error categorie
Flight::route('GET /api/psperrorcategories/@idPSP', function($idPSP) {
	PSPErrorCategorieController::show($idPSP);
});

// get all error phases
Flight::route('GET /api/pspphases', function() {
	PSPPhaseController::index();
});

// get specific error phases
Flight::route('GET /api/pspphases/@idPSP', function($idPSP) {
	PSPPhaseController::show($idPSP);
});

// add psp data
Flight::route('POST /api/userpspdata', function() {
	UserPSPDataController::store();
});

// remove psp data
Flight::route('DELETE /api/userpspdata/@idUser', function($idUser) {
	UserPSPDataController::delete($idUser);
});

// get all psps of an user
Flight::route('GET /api/userpspdata/@idUser', function($idUser) {
	UserPSPDataController::show($idUser);
});

// get tasks, status and users
Flight::route('GET /api/tasks/all', function() {
	$idProject = (int) Flight::request()->query['idProject'];
    $idUser = (int) Flight::request()->query['idUser'];
	TaskController::get_project_tasks_and_users($idUser, $idProject);
});

// get update big table psp data
Flight::route('POST /api/update_psp_data/@idUser', function($idUser) {
	UserPSPDataController::update_user_psps($idUser);
});

// get 
Flight::route('GET /api/get_user_data/@idUser', function($idUser) {
	UserPSPDataController::get_user_psps($idUser);
});