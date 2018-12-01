<?php
error_reporting(-1);
ini_set('display_errors', 'On');
set_error_handler("var_dump");

// composer dependencies
require_once __DIR__ . '/../vendor/autoload.php';
// import settings
require_once __DIR__ . '/../settings/blade_init.php';

// create database instance
require_once __DIR__ . '/../settings/DBInit.php';

// import routes
require_once __DIR__ . '/../routes/web.php';
require_once __DIR__ . '/../routes/api.php';

// auth
$db = DBInit::getInstance();
$auth = new \Delight\Auth\Auth($db);

// Start app
Flight::start();