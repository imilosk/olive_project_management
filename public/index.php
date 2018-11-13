<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../settings/blade_init.php';

require_once __DIR__ . '/../routes/web.php';
require_once __DIR__ . '/../routes/api.php';

// Start app
Flight::start();