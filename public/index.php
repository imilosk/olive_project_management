<?php

// composer dependencies
require_once __DIR__ . '/../vendor/autoload.php';
// import settings
require_once __DIR__ . '/../settings/blade_init.php';

// 
require_once __DIR__ . '/../settings/DBInit.php';

// import routes
require_once __DIR__ . '/../routes/web.php';
require_once __DIR__ . '/../routes/api.php';

// Start app
Flight::start();